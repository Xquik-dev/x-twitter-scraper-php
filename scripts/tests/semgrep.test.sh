#!/usr/bin/env bash

# SPDX-FileCopyrightText: 2026 Xquik contributors
#
# SPDX-License-Identifier: Apache-2.0

# Runs scripts/semgrep in a throwaway repository. A fake git stands in for
# the download of the Semgrep rules and a fake semgrep stands in for the
# scanner, so no test reaches GitHub or scans real code.

set -euo pipefail

# shellcheck source=scripts/tests/support.sh
source "$(dirname -- "${BASH_SOURCE[0]}")/support.sh"

readonly pinned_commit="5a8a6beafb1a848591f44bdddcb51584474493c4"
readonly fetched_rules="php/lang/security/assert-use.yaml
php/lang/security/file-inclusion.yaml
php/lang/security/tainted-exec.yaml"

prepare_scan() {
  copy_file scripts/semgrep
  fake git <<'EOF'
#!/bin/sh
# Stands in for git. A fetch records the repository and the commit it is
# asked for. A checkout writes 3 rule files, as the real rules repository
# would. FAKE_FETCH_FAILS breaks the fetch and FAKE_RULES_HEAD names the
# commit that the checkout lands on.
case "$1" in
  init) mkdir -p "$3" ;;
  -C)
    rules="$2"
    case "$3" in
      fetch)
        shift 3
        echo "$*" >>"$FAKE_LOGS/fetch"
        [ -z "${FAKE_FETCH_FAILS:-}" ] || exit 128
        ;;
      checkout)
        mkdir -p "$rules/php/lang/security"
        for name in assert-use file-inclusion tainted-exec; do
          echo "rules: []" >"$rules/php/lang/security/$name.yaml"
        done
        ;;
      rev-parse) echo "${FAKE_RULES_HEAD:-5a8a6beafb1a848591f44bdddcb51584474493c4}" ;;
    esac
    ;;
esac
EOF
  fake semgrep <<'EOF'
#!/bin/sh
# Stands in for Semgrep. It records its arguments with the rules folder
# replaced by RULES, and the rule files that folder holds. It exits with
# FAKE_SEMGREP_EXIT, as Semgrep exits with 1 on a finding.
rules="$3"
line=""
for argument in "$@"; do
  [ "$argument" != "$rules" ] || argument="RULES/php"
  line="$line $argument"
done
echo "${line# }" >>"$FAKE_LOGS/semgrep"
(cd "$rules/.." && find php -type f | LC_ALL=C sort) >>"$FAKE_LOGS/rules"
exit "${FAKE_SEMGREP_EXIT:-0}"
EOF
}

test_a_clean_scan_uses_every_php_rule_of_the_pinned_commit() {
  prepare_scan

  run_in_repo scripts/semgrep

  assert_equal "" "$run_stderr" "stderr"
  assert_equal 0 "$run_status" "the exit code"
  assert_equal "--quiet --depth 1 https://github.com/semgrep/semgrep-rules.git $pinned_commit" \
    "$(log_of fetch)" "the rules download"
  assert_equal "scan --config RULES/php --error --metrics=off --disable-version-check --exclude vendor --exclude .phpunit.cache ." \
    "$(log_of semgrep)" "the Semgrep call"
  assert_equal "$fetched_rules" "$(log_of rules)" "the rule files that Semgrep read"
}

test_a_finding_fails_the_scan() {
  prepare_scan
  run_env+=("FAKE_SEMGREP_EXIT=1")

  run_in_repo scripts/semgrep

  assert_equal 1 "$run_status" "the exit code"
  assert_equal "$fetched_rules" "$(log_of rules)" "the rule files that Semgrep read"
}

test_a_failed_rules_download_stops_before_the_scan() {
  prepare_scan
  run_env+=("FAKE_FETCH_FAILS=1")

  run_in_repo scripts/semgrep

  assert_equal 1 "$run_status" "the exit code"
  assert_equal "Could not fetch the Semgrep rules. Check your network, then rerun." "$run_stderr" "stderr"
  assert_equal "" "$(log_of semgrep)" "the Semgrep call"
}

test_rules_at_another_commit_stop_before_the_scan() {
  prepare_scan
  run_env+=("FAKE_RULES_HEAD=0000000000000000000000000000000000000000")

  run_in_repo scripts/semgrep

  assert_equal 1 "$run_status" "the exit code"
  assert_equal "The fetched Semgrep rules are not at the pinned commit. Rerun, and check the pin in scripts/semgrep if it happens again." \
    "$run_stderr" "stderr"
  assert_equal "" "$(log_of semgrep)" "the Semgrep call"
}

run_tests
