#!/usr/bin/env bash

# SPDX-FileCopyrightText: 2026 Xquik contributors
#
# SPDX-License-Identifier: Apache-2.0

set -euo pipefail

# shellcheck source=scripts/tests/support.sh
source "$(dirname -- "${BASH_SOURCE[0]}")/support.sh"

readonly pinned_commit="5a8a6beafb1a848591f44bdddcb51584474493c4"
readonly fetched_rules="php/lang/security/assert-use.yaml
php/lang/security/file-inclusion.yaml
php/lang/security/tainted-exec.yaml"

partial_parsing_report() {
  local message="\`$1\` was unexpected"
  printf '{"results":[],"errors":[{"code":3,"level":"warn","type":["PartialParsing",[{"path":"src/Model.php","start":{"line":5,"col":%s,"offset":0},"end":{"line":5,"col":%s,"offset":5}}]],"message":"Syntax error at line src/Model.php:5:\\n %s","path":"src/Model.php","spans":[{"file":"src/Model.php","start":{"line":5,"col":%s,"offset":0},"end":{"line":5,"col":%s,"offset":5}}]}]}' \
    "$2" "$3" "$message" "$2" "$3"
}

prepare_scan() {
  copy_file scripts/semgrep
  use_real_php
  write_file src/Model.php <<'EOF'
<?php

final class Model
{
    #[Required(list: Item::class)]
    public array $items;
}
EOF
  run_env+=("FAKE_SEMGREP_REPORT=$(partial_parsing_report list: 16 21)")
  fake git <<'EOF'
#!/bin/sh
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
rules="$3"
report='{"results":[],"errors":[]}'
[ -z "${FAKE_SEMGREP_REPORT+set}" ] || report="$FAKE_SEMGREP_REPORT"
line=""
for argument in "$@"; do
  case "$argument" in
    "$rules") argument="RULES/php" ;;
    --json-output=*)
      printf '%s' "$report" >"${argument#--json-output=}"
      argument="--json-output=REPORT"
      ;;
  esac
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
  assert_equal "scan --config RULES/php --error --metrics=off --disable-version-check --json-output=REPORT --exclude vendor --exclude .phpunit.cache ." \
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

test_a_file_that_semgrep_could_not_parse_fails_the_scan_and_is_named() {
  prepare_scan
  run_env+=('FAKE_SEMGREP_REPORT={"results":[],"errors":[{"code":3,"level":"warn","type":["PartialParsing",[{"path":"src/Client.php","start":{"line":4,"col":5,"offset":0},"end":{"line":4,"col":17,"offset":12}}]],"message":"Syntax error at line src/Client.php:4","path":"src/Client.php","spans":[{"file":"src/Client.php","start":{"line":4,"col":5,"offset":0},"end":{"line":4,"col":17,"offset":12}}]},{"code":3,"level":"warn","type":"Syntax error","message":"Syntax error at line src/Core/Util.php:9","path":"src/Core/Util.php","spans":[{"file":"src/Core/Util.php","start":{"line":9,"col":1,"offset":0},"end":{"line":9,"col":6,"offset":5}}]}]}')

  run_in_repo scripts/semgrep

  assert_equal 1 "$run_status" "the exit code"
  assert_equal "Semgrep could not parse src/Client.php at line 4 and src/Core/Util.php at line 9, so the scan is incomplete. Rewrite that code so Semgrep parses it, then rerun." \
    "$run_stderr" "stderr"
}

test_a_named_argument_called_list_that_semgrep_cannot_parse_passes() {
  prepare_scan

  run_in_repo scripts/semgrep

  assert_equal "" "$run_stderr" "stderr"
  assert_equal 0 "$run_status" "the exit code"
  assert_ends_with "$run_stdout" "Allowed 1 Semgrep errors for a named argument called list, which Semgrep cannot parse yet." "stdout"
}

test_the_list_message_over_other_text_fails_the_scan() {
  prepare_scan
  run_env+=("FAKE_SEMGREP_REPORT=$(partial_parsing_report list: 7 12)")

  run_in_repo scripts/semgrep

  assert_equal 1 "$run_status" "the exit code"
  assert_equal "Semgrep could not parse src/Model.php at line 5, so the scan is incomplete. Rewrite that code so Semgrep parses it, then rerun." \
    "$run_stderr" "stderr"
}

test_another_parse_error_over_the_list_argument_fails_the_scan() {
  prepare_scan
  run_env+=("FAKE_SEMGREP_REPORT=$(partial_parsing_report Item 16 21)")

  run_in_repo scripts/semgrep

  assert_equal 1 "$run_status" "the exit code"
  assert_equal "Semgrep could not parse src/Model.php at line 5, so the scan is incomplete. Rewrite that code so Semgrep parses it, then rerun." \
    "$run_stderr" "stderr"
}

test_an_exemption_that_matches_nothing_fails_the_scan() {
  prepare_scan
  run_env+=('FAKE_SEMGREP_REPORT={"results":[],"errors":[]}')

  run_in_repo scripts/semgrep

  assert_equal 1 "$run_status" "the exit code"
  assert_equal "Semgrep now parses every named argument called list, so its exemption matched nothing. Remove the exemption from scripts/semgrep, then rerun." \
    "$run_stderr" "stderr"
}

test_a_scan_without_a_report_fails() {
  prepare_scan
  run_env+=("FAKE_SEMGREP_REPORT=")

  run_in_repo scripts/semgrep

  assert_equal 1 "$run_status" "the exit code"
  assert_equal "Semgrep wrote no report, so the scan cannot show that it read every file. Rerun, and update Semgrep if it happens again." \
    "$run_stderr" "stderr"
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
