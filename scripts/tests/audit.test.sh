#!/usr/bin/env bash

# SPDX-FileCopyrightText: 2026 Xquik contributors
#
# SPDX-License-Identifier: Apache-2.0

set -euo pipefail

# shellcheck source=scripts/tests/support.sh
source "$(dirname -- "${BASH_SOURCE[0]}")/support.sh"

readonly runtime_package="example/shipped"
readonly development_package="example/build-tool"
readonly advisory="GHSA-aaaa-bbbb-cccc"
readonly advisory_name="PKSA-abcd-1234-efgh"
readonly audit_start="==> Validating locked Composer metadata
==> Auditing locked dependencies"

day_from_today() {
  jq -nr --argjson days "$1" 'now + $days * 86400 | strftime("%Y-%m-%d")'
}

prepare_audit() {
  copy_file scripts/audit
  copy_file scripts/verify-audit.php
  copy_file scripts/verify-licenses.php
  [[ -f "$tests_root/vendor/autoload.php" ]] ||
    fail_test "vendor/autoload.php is missing. Run ./scripts/bootstrap first."
  ln -s "$tests_root/vendor" "$sandbox_repo/vendor"
  write_file composer.lock <<EOF
{
  "packages": [{"name": "$runtime_package", "version": "1.0.0"}],
  "packages-dev": [{"name": "$development_package", "version": "2.0.0"}]
}
EOF
  write_file audit-exceptions.json <<'EOF'
{
  "exceptions": []
}
EOF
  fake composer <<'EOF'
#!/bin/sh
echo "$*" >>"$FAKE_LOGS/composer"
case "$1" in
  audit)
    cat "$FAKE_AUDIT_REPORT"
    jq -e '.advisories == [] and .abandoned == [] and .filter == []' "$FAKE_AUDIT_REPORT" >/dev/null
    ;;
  licenses)
    echo "{\"dependencies\":{\"example/shipped\":{\"version\":\"1.0.0\",\"license\":[\"${FAKE_LICENSE:-MIT}\"]}}}"
    ;;
esac
EOF
  write_php_wrapper "$tests_root/scripts/tests/fake-packagist.php"
  mkdir -p "$sandbox/packagist"
  echo '{"advisories":[],"abandoned":[],"filter":[]}' >"$sandbox/audit-report.json"
  run_env=("FAKE_AUDIT_REPORT=$sandbox/audit-report.json" "FAKE_PACKAGIST_DIR=$sandbox/packagist")
}

report_advisory() {
  jq -n \
    --arg package "$1" \
    --arg severity "$2" \
    --arg key "${3:-advisories}" \
    --arg advisory "$advisory" \
    --arg name "$advisory_name" '
    {advisories: [], abandoned: [], filter: []} + {($key): {($package): [{
      advisoryId: $name,
      packageName: $package,
      affectedVersions: "<3.0.0",
      title: "Example advisory",
      cve: "CVE-2026-00001",
      link: "https://example.com/advisory",
      reportedAt: "2026-01-01T00:00:00+00:00",
      sources: [{name: "GitHub", remoteId: $advisory}],
      severity: $severity
    }]}}' >"$sandbox/audit-report.json"
}

list_exception() {
  write_file audit-exceptions.json <<EOF
{
  "exceptions": [
    {
      "advisory": "$advisory",
      "path": "example/root-tool > $1",
      "reason": "${3:-build-time only}",
      "recheck": "$2"
    }
  ]
}
EOF
}

packagist_lists() {
  local version entries=""
  for version in "$@"; do
    entries="$entries${entries:+,}{\"version\":\"$version\"}"
  done
  echo "{\"packages\":{\"$development_package\":[$entries]}}" >"$sandbox/packagist/example__build-tool.json"
}

assert_blocked() {
  assert_equal 1 "$run_status" "the exit code"
  assert_equal "$audit_start" "$run_stdout" "stdout"
  assert_equal "$1" "$run_stderr" "stderr"
}

runtime_finding_blocks() {
  prepare_audit
  list_exception "$runtime_package" "$(day_from_today 10)"
  report_advisory "$runtime_package" "$1"

  run_in_repo scripts/audit

  assert_blocked "$runtime_package ships with the SDK and has $advisory_name. Update it.
$advisory matches no audit finding. Remove it from audit-exceptions.json."
}

test_a_low_finding_in_a_shipped_package_blocks_even_when_listed() {
  runtime_finding_blocks low
}

test_a_medium_finding_in_a_shipped_package_blocks_even_when_listed() {
  runtime_finding_blocks medium
}

test_a_high_finding_in_a_shipped_package_blocks_even_when_listed() {
  runtime_finding_blocks high
}

test_a_critical_finding_in_a_shipped_package_blocks_even_when_listed() {
  runtime_finding_blocks critical
}

unlisted_development_finding_blocks() {
  prepare_audit
  report_advisory "$development_package" "$1"

  run_in_repo scripts/audit

  assert_blocked "$development_package has $advisory_name. Update it, or list it in audit-exceptions.json if no fix exists."
  assert_equal "" "$(log_of packagist)" "the Packagist requests"
}

test_an_unlisted_low_finding_in_a_development_package_blocks() {
  unlisted_development_finding_blocks low
}

test_an_unlisted_critical_finding_in_a_development_package_blocks() {
  unlisted_development_finding_blocks critical
}

test_an_audit_without_findings_passes_and_asks_composer_for_every_severity() {
  prepare_audit

  run_in_repo scripts/audit

  assert_equal "" "$run_stderr" "stderr"
  assert_equal 0 "$run_status" "the exit code"
  assert_equal "$audit_start
No advisories or abandoned packages found.
==> Checking dependency license policy
Verified 1 dependency licenses." "$run_stdout" "stdout"
  assert_equal "validate --strict --no-check-publish
audit --locked --abandoned=report --format=json
licenses --format=json" "$(log_of composer)" "the Composer calls"
}

test_a_listed_development_finding_without_a_fix_passes_until_its_recheck_date() {
  prepare_audit
  list_exception "$development_package" "$(day_from_today 30)"
  report_advisory "$development_package" high
  packagist_lists 2.0.0 1.9.0 3.0.0-beta1

  run_in_repo scripts/audit

  assert_equal "" "$run_stderr" "stderr"
  assert_equal 0 "$run_status" "the exit code"
  assert_equal "$audit_start
Allowed $advisory in example/root-tool > $development_package until its recheck date.
Every advisory is a reviewed development-only exception.
==> Checking dependency license policy
Verified 1 dependency licenses." "$run_stdout" "stdout"
  assert_equal "https://repo.packagist.org/p2/$development_package.json" "$(log_of packagist)" "the Packagist requests"
}

test_a_listed_development_finding_blocks_once_packagist_has_a_fixed_release() {
  prepare_audit
  list_exception "$development_package" "$(day_from_today 10)"
  report_advisory "$development_package" low
  packagist_lists 3.0.0 2.0.0

  run_in_repo scripts/audit

  assert_blocked "$development_package 3.0.0 fixes $advisory. Update it and remove the exception."
}

test_a_listed_development_finding_blocks_on_its_recheck_date() {
  prepare_audit
  list_exception "$development_package" "$(day_from_today 0)"
  report_advisory "$development_package" low
  packagist_lists 2.0.0

  run_in_repo scripts/audit

  assert_blocked "$advisory reached its recheck date. Review it, then update or remove the entry."
}

test_an_exception_that_rechecks_more_than_30_days_out_blocks() {
  prepare_audit
  list_exception "$development_package" "$(day_from_today 31)"
  report_advisory "$development_package" low
  packagist_lists 2.0.0

  run_in_repo scripts/audit

  assert_blocked "$advisory rechecks more than 30 days out. Pick an earlier date."
}

test_an_exception_with_another_reason_blocks() {
  prepare_audit
  list_exception "$development_package" "$(day_from_today 10)" "low severity"
  report_advisory "$development_package" low
  packagist_lists 2.0.0

  run_in_repo scripts/audit

  assert_blocked "audit-exceptions.json entry 0 has reason \"low severity\". Use \"build-time only\" or \"peer dependency provided by the host\"."
}

test_an_exception_that_matches_no_finding_blocks() {
  prepare_audit
  list_exception "$development_package" "$(day_from_today 10)"

  run_in_repo scripts/audit

  assert_blocked "$advisory matches no audit finding. Remove it from audit-exceptions.json."
}

test_a_listed_finding_blocks_when_packagist_does_not_answer() {
  prepare_audit
  list_exception "$development_package" "$(day_from_today 10)"
  report_advisory "$development_package" low

  run_in_repo scripts/audit

  assert_blocked "Could not read Packagist metadata for $development_package. Check your network, then try again."
}

test_an_advisory_that_the_composer_config_ignores_blocks() {
  prepare_audit
  report_advisory "$development_package" low ignored-advisories

  run_in_repo scripts/audit

  assert_blocked "$development_package has $advisory_name, which the Composer config ignores. Remove that ignore rule, then update the package."
}

test_a_package_on_a_composer_filter_list_blocks() {
  prepare_audit
  jq -n --arg package "$development_package" '
    {advisories: [], abandoned: [], filter: {($package): [{
      packageName: $package,
      listName: "malware",
      constraint: "*",
      url: null,
      reason: "Example reason",
      id: null,
      source: null
    }]}}' >"$sandbox/audit-report.json"

  run_in_repo scripts/audit

  assert_blocked "$development_package is on the Composer malware filter list. Replace it."
}

test_an_unreachable_repository_blocks_because_the_audit_is_incomplete() {
  prepare_audit
  echo '{"advisories":[],"unreachable-repositories":["The repository did not answer."],"abandoned":[],"filter":[]}' \
    >"$sandbox/audit-report.json"

  run_in_repo scripts/audit

  assert_blocked "Composer could not reach a package repository, so the audit is incomplete. Check your network, then run it again."
}

test_an_abandoned_package_blocks() {
  prepare_audit
  echo '{"advisories":[],"abandoned":{"example/old":"example/new"},"filter":[]}' >"$sandbox/audit-report.json"

  run_in_repo scripts/audit

  assert_blocked "example/old is abandoned. Replace it with example/new."
}

test_an_audit_that_prints_no_report_blocks() {
  prepare_audit
  : >"$sandbox/audit-report.json"

  run_in_repo scripts/audit

  assert_blocked "Composer audit output is not valid JSON. Rerun composer audit and check its errors."
}

test_a_dependency_with_an_unapproved_license_blocks() {
  prepare_audit
  run_env+=("FAKE_LICENSE=GPL-3.0-only")

  run_in_repo scripts/audit

  assert_equal 1 "$run_status" "the exit code"
  assert_equal "$runtime_package uses the unapproved license GPL-3.0-only.
Dependency licenses need review. Approve or remove each listed dependency." "$run_stderr" "stderr"
}

run_tests
