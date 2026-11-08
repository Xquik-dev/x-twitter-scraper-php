#!/usr/bin/env bash

# SPDX-FileCopyrightText: 2026 Xquik contributors
#
# SPDX-License-Identifier: Apache-2.0

set -euo pipefail

# shellcheck source=scripts/tests/support.sh
source "$(dirname -- "${BASH_SOURCE[0]}")/support.sh"

readonly account_path='"/api/v1/account":{"get":{"responses":{"200":{"description":"OK","content":{"application/json":{"schema":{"type":"object","properties":{"brandNewField":{"type":"string"}}}}}}}}}'
readonly new_path='"/api/v1/brand-new":{"get":{"responses":{"200":{"description":"OK"}}}}'

write_spec() {
  printf '{"openapi":"3.1.0","paths":{%s}}\n' "$1" >"$sandbox/spec.json"
}

accept_every_listed_difference() {
  run_in_repo php scripts/verify-api-fields.php --list
  grep -v ' uncovered$' <<<"$run_stdout" |
    jq -R . |
    jq -s '[{reason: "Accepted by this test.", differences: .}]' >"$sandbox_repo/accepted-field-differences.json"
}

prepare_check() {
  copy_file scripts/verify-api-fields.php
  ln -s "$tests_root/vendor" "$sandbox_repo/vendor"
  ln -s "$tests_root/src" "$sandbox_repo/src"
  write_file accepted-field-differences.json <<<'[]'
  write_file excluded-operations.json <<<'[]'
  use_real_php
  run_env+=("XQUIK_OPENAPI_SPEC=$sandbox/spec.json")
}

test_a_response_field_the_sdk_lacks_fails_the_check() {
  prepare_check
  write_spec "$account_path"

  run_in_repo php scripts/verify-api-fields.php

  assert_equal 1 "$run_status" "the exit code"
  assert_contains "$run_stderr" "GET /api/v1/account response missing brandNewField" "stderr"
}

test_an_accepted_difference_passes_the_check() {
  prepare_check
  write_spec "$account_path"
  accept_every_listed_difference

  run_in_repo php scripts/verify-api-fields.php

  assert_equal 0 "$run_status" "the exit code"
  assert_contains "$run_stdout" "The SDK's fields match the API for 1 operations" "stdout"
}

test_an_operation_the_sdk_lacks_fails_the_check() {
  prepare_check
  write_spec "$new_path"

  run_in_repo php scripts/verify-api-fields.php

  assert_equal 1 "$run_status" "the exit code"
  assert_contains "$run_stderr" "GET /api/v1/brand-new is in the API but not in the SDK." "stderr"
}

test_an_excluded_operation_passes_the_check() {
  prepare_check
  write_spec "$new_path"
  write_file excluded-operations.json <<<'[{"reason":"Excluded by this test.","operations":["GET /api/v1/brand-new"]}]'

  run_in_repo php scripts/verify-api-fields.php

  assert_equal 0 "$run_status" "the exit code"
}

test_an_accepted_line_the_check_no_longer_finds_fails_as_stale() {
  prepare_check
  write_spec "$account_path"
  accept_every_listed_difference
  write_spec '"/api/v1/account":{"get":{"responses":{"200":{"description":"OK"}}}}'

  run_in_repo php scripts/verify-api-fields.php

  assert_equal 1 "$run_status" "the exit code"
  assert_contains "$run_stderr" "which the check no longer finds" "stderr"
}

run_tests
