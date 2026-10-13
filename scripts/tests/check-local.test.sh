#!/usr/bin/env bash

# SPDX-FileCopyrightText: 2026 Xquik contributors
#
# SPDX-License-Identifier: Apache-2.0

# Runs bin/check-local in a throwaway repository. Stubs stand in for the
# check scripts. Fake commands stand in for the GitHub CLI, uv, Composer,
# PHP, Semgrep and shellcheck, so no test reaches GitHub or runs a real check.

set -euo pipefail

# shellcheck source=scripts/tests/support.sh
source "$(dirname -- "${BASH_SOURCE[0]}")/support.sh"

readonly check_order="bootstrap
lint
shellcheck
test-scripts
uvx
composer
syntax
test
coverage
audit
check-reproducible
semgrep"
readonly passed_line="Passed install, lint, shellcheck, script tests, REUSE, platform, syntax, 12 tests, coverage, audit, reproducible archive and Semgrep."
readonly statuses="repos/Xquik-dev/x-twitter-scraper-php/statuses"

# Builds a repository whose checks all pass, on a machine with every tool.
prepare_checks() {
  local name
  copy_file bin/check-local
  for name in bootstrap lint test-scripts coverage audit check-reproducible semgrep; do
    stub "scripts/$name" <<EOF
#!/usr/bin/env bash
# Stands in for scripts/$name. It fails when FAKE_FAILING_CHECK names it.
echo "$name" >>"\$FAKE_LOGS/order"
[[ "\${FAKE_FAILING_CHECK:-}" != "$name" ]]
EOF
  done
  stub scripts/test <<'EOF'
#!/usr/bin/env bash
# Stands in for scripts/test. It prints the PHPUnit summary that
# FAKE_TEST_SUMMARY holds and fails when FAKE_FAILING_CHECK names it.
echo "test" >>"$FAKE_LOGS/order"
printf '%b\n' "${FAKE_TEST_SUMMARY:-OK (12 tests, 30 assertions)}"
[[ "${FAKE_FAILING_CHECK:-}" != "test" ]]
EOF
  write_file src/Example.php <<'EOF'
<?php
EOF
  fake shellcheck <<'EOF'
#!/bin/sh
# Stands in for shellcheck. It records the scripts it is asked to check.
echo "shellcheck" >>"$FAKE_LOGS/order"
echo "$*" >>"$FAKE_LOGS/shellcheck"
EOF
  fake uvx <<'EOF'
#!/bin/sh
# Stands in for uvx. It records its arguments.
echo "uvx" >>"$FAKE_LOGS/order"
echo "$*" >>"$FAKE_LOGS/uvx"
EOF
  fake composer <<'EOF'
#!/bin/sh
# Stands in for Composer. It records its arguments.
echo "composer" >>"$FAKE_LOGS/order"
echo "$*" >>"$FAKE_LOGS/composer"
EOF
  fake php <<'EOF'
#!/bin/sh
# Stands in for PHP. It prints a version for -r and records each syntax check.
case "$*" in
  "-r "*) printf '8.5.0' ;;
  *" -l "*)
    echo "syntax" >>"$FAKE_LOGS/order"
    echo "$*" >>"$FAKE_LOGS/php"
    ;;
esac
EOF
  fake semgrep <<'EOF'
#!/bin/sh
# Stands in for Semgrep. bin/check-local only checks that it exists.
exit 0
EOF
  fake gh <<'EOF'
#!/bin/sh
# Stands in for the GitHub CLI. It knows every commit unless
# FAKE_GH_UNKNOWN_COMMIT is set, and records each status it is asked to post.
case "$*" in
  "api repos/Xquik-dev/x-twitter-scraper-php/commits/"*)
    [ -z "${FAKE_GH_UNKNOWN_COMMIT:-}" ]
    exit $?
    ;;
esac
state=""
description=""
for argument in "$@"; do
  case "$argument" in
    repos/*) endpoint="$argument" ;;
    state=*) state="${argument#state=}" ;;
    description=*) description="${argument#description=}" ;;
  esac
done
echo "$endpoint $state $description" >>"$FAKE_LOGS/gh"
EOF
  commit_repo
}

test_a_passing_run_lists_the_checks_in_order_and_runs_reuse_through_uvx() {
  prepare_checks

  run_in_repo bin/check-local --no-status

  assert_equal "" "$run_stderr" "stderr"
  assert_equal 0 "$run_status" "the exit code"
  assert_ends_with "$run_stdout" "$passed_line" "stdout"
  assert_contains "$run_stdout" "Commit status not posted because --no-status was passed." "stdout"
  assert_equal "$check_order" "$(log_of order)" "the order of the checks"
  assert_equal "--from reuse==6.2.0 reuse lint" "$(log_of uvx)" "the uvx call"
  assert_equal "check-platform-reqs --no-dev --lock" "$(log_of composer)" "the Composer call"
  assert_equal "-d display_errors=stderr -l src/Example.php" "$(log_of php)" "the syntax check"
  assert_equal "" "$(log_of gh)" "the posted statuses"
}

test_shellcheck_reads_every_bash_script_and_skips_other_files() {
  prepare_checks
  stub scripts/tests/sample.test.sh <<'EOF'
#!/usr/bin/env bash
exit 0
EOF
  write_file scripts/verify-sample.php <<'EOF'
<?php
EOF
  sandbox_git add --all
  sandbox_git commit --quiet --message "Add files"

  run_in_repo bin/check-local --no-status

  assert_equal 0 "$run_status" "the exit code"
  assert_equal "--external-sources bin/check-local scripts/audit scripts/bootstrap scripts/check-reproducible scripts/coverage scripts/lint scripts/semgrep scripts/test scripts/test-scripts scripts/tests/sample.test.sh" \
    "$(log_of shellcheck)" "the shellcheck call"
}

test_a_clean_pushed_head_gets_a_pending_status_then_a_success_status() {
  local head
  prepare_checks
  head="$(sandbox_git rev-parse HEAD)"

  run_in_repo bin/check-local

  assert_equal "" "$run_stderr" "stderr"
  assert_equal 0 "$run_status" "the exit code"
  assert_equal "$statuses/$head pending Local checks are running.
$statuses/$head success $passed_line" \
    "$(log_of gh)" "the posted statuses"
}

test_the_success_text_counts_the_tests_that_ran_and_leaves_out_skipped_ones() {
  local head
  prepare_checks
  head="$(sandbox_git rev-parse HEAD)"
  run_env+=('FAKE_TEST_SUMMARY=\033[30;42mOK, but some tests were skipped!\033[0m\n\033[30;42mTests: 247\033[0m\033[30;42m, Assertions: 689\033[0m\033[30;42m, Skipped: 7\033[0m\033[30;42m.\033[0m')

  run_in_repo bin/check-local

  assert_equal 0 "$run_status" "the exit code"
  assert_equal "$statuses/$head pending Local checks are running.
$statuses/$head success Passed install, lint, shellcheck, script tests, REUSE, platform, syntax, 240 tests, coverage, audit, reproducible archive and Semgrep." \
    "$(log_of gh)" "the posted statuses"
}

test_the_success_text_fits_the_140_character_limit_of_a_commit_status() {
  local description
  prepare_checks
  run_env+=('FAKE_TEST_SUMMARY=OK (98765 tests, 99999 assertions)')

  run_in_repo bin/check-local

  assert_equal 0 "$run_status" "the exit code"
  description="$(log_of gh | sed -n 's/^.* success //p')"
  assert_ends_with "$description" "98765 tests, coverage, audit, reproducible archive and Semgrep." "the success text"
  if ((${#description} >= 140)); then
    fail_test "The success text has ${#description} characters. GitHub accepts at most 140."
  fi
}

test_a_working_tree_with_changes_gets_no_status() {
  prepare_checks
  write_file untracked.txt <<'EOF'
A change.
EOF

  run_in_repo bin/check-local

  assert_equal 0 "$run_status" "the exit code"
  assert_contains "$run_stdout" "Commit status not posted because the working tree has changes." "stdout"
  assert_equal "" "$(log_of gh)" "the posted statuses"
}

test_a_commit_that_github_lacks_gets_no_status() {
  prepare_checks
  run_env+=("FAKE_GH_UNKNOWN_COMMIT=1")

  run_in_repo bin/check-local

  assert_equal 0 "$run_status" "the exit code"
  assert_contains "$run_stdout" "Commit status not posted because GitHub has no commit" "stdout"
  assert_equal "" "$(log_of gh)" "the posted statuses"
}

test_a_run_without_uv_stops_even_when_another_reuse_is_installed() {
  prepare_checks
  remove_tool uvx
  fake reuse <<'EOF'
#!/bin/sh
# Stands in for a reuse that is not the pinned one.
echo "reuse" >>"$FAKE_LOGS/order"
EOF

  run_in_repo bin/check-local --no-status

  assert_equal 1 "$run_status" "the exit code"
  assert_equal "Check failed at Required tools. Install uv with brew install uv, then rerun." "$run_stderr" "stderr"
  assert_equal "" "$(log_of order)" "the checks that ran"
}

test_a_run_without_semgrep_stops_with_the_install_command() {
  prepare_checks
  remove_tool semgrep

  run_in_repo bin/check-local --no-status

  assert_equal 1 "$run_status" "the exit code"
  assert_equal "Check failed at Required tools. Install Semgrep with brew install semgrep, then rerun." \
    "$run_stderr" "stderr"
  assert_equal "" "$(log_of order)" "the checks that ran"
}

test_a_failing_check_stops_the_run_and_posts_a_failure_status_that_names_it() {
  local head
  prepare_checks
  head="$(sandbox_git rev-parse HEAD)"
  run_env+=("FAKE_FAILING_CHECK=test")

  run_in_repo bin/check-local

  assert_equal 1 "$run_status" "the exit code"
  assert_equal "Check failed at Tests. Fix the failing tests above, then rerun." "$run_stderr" "stderr"
  assert_equal "bootstrap
lint
shellcheck
test-scripts
uvx
composer
syntax
test" "$(log_of order)" "the checks that ran"
  assert_equal "$statuses/$head pending Local checks are running.
$statuses/$head failure Failed at Tests." \
    "$(log_of gh)" "the posted statuses"
}

test_a_semgrep_finding_posts_a_failure_status_and_no_success() {
  local head
  prepare_checks
  head="$(sandbox_git rev-parse HEAD)"
  run_env+=("FAKE_FAILING_CHECK=semgrep")

  run_in_repo bin/check-local

  assert_equal 1 "$run_status" "the exit code"
  assert_equal "Check failed at Semgrep PHP rules. Fix the Semgrep error or findings above, then rerun." \
    "$run_stderr" "stderr"
  assert_equal "$statuses/$head pending Local checks are running.
$statuses/$head failure Failed at Semgrep PHP rules." \
    "$(log_of gh)" "the posted statuses"
}

test_an_audit_finding_posts_a_failure_status_and_skips_the_later_checks() {
  local head
  prepare_checks
  head="$(sandbox_git rev-parse HEAD)"
  run_env+=("FAKE_FAILING_CHECK=audit")

  run_in_repo bin/check-local

  assert_equal 1 "$run_status" "the exit code"
  assert_equal "Check failed at Dependency audit. Update the packages named above, or list an unfixable development-only finding in audit-exceptions.json." \
    "$run_stderr" "stderr"
  assert_not_contains "$(log_of order)" "semgrep" "the checks that ran"
  assert_equal "$statuses/$head pending Local checks are running.
$statuses/$head failure Failed at Dependency audit." \
    "$(log_of gh)" "the posted statuses"
}

test_a_check_that_changes_the_tree_fails_the_run() {
  local head
  prepare_checks
  stub scripts/coverage <<'EOF'
#!/usr/bin/env bash
# Stands in for a check that leaves a file behind.
echo "coverage" >>"$FAKE_LOGS/order"
echo "left behind" >leftover.txt
EOF
  sandbox_git add --all
  sandbox_git commit --quiet --message "Use a check that changes the tree"
  head="$(sandbox_git rev-parse HEAD)"

  run_in_repo bin/check-local

  assert_equal 1 "$run_status" "the exit code"
  assert_contains "$run_stdout" "?? leftover.txt" "stdout"
  assert_equal "Check failed at Unchanged working tree. A check changed or added the files above. Fix that check so it leaves the tree alone, then rerun." \
    "$run_stderr" "stderr"
  assert_equal "$statuses/$head pending Local checks are running.
$statuses/$head failure Failed at Unchanged working tree." \
    "$(log_of gh)" "the posted statuses"
}

test_an_unknown_option_stops_with_the_usage_line() {
  prepare_checks

  run_in_repo bin/check-local --fast

  assert_equal 2 "$run_status" "the exit code"
  assert_equal "Unknown option --fast. Run bin/check-local or bin/check-local --no-status." "$run_stderr" "stderr"
  assert_equal "" "$(log_of order)" "the checks that ran"
}

run_tests
