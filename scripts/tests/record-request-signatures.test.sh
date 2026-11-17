#!/usr/bin/env bash

# SPDX-FileCopyrightText: 2026 Xquik contributors
#
# SPDX-License-Identifier: Apache-2.0

set -euo pipefail

# shellcheck source=scripts/tests/support.sh
source "$(dirname -- "${BASH_SOURCE[0]}")/support.sh"

version="$(sed -n "s/^const VERSION = '\(.*\)';$/\1/p" "$tests_root/src/Version.php")"
readonly version

prepare_record() {
  copy_file scripts/record-request-signatures.php
  ln -s "$tests_root/vendor" "$sandbox_repo/vendor"
  ln -s "$tests_root/src" "$sandbox_repo/src"
  use_real_php
}

test_the_version_bump_records_the_new_release() {
  prepare_record
  sed "1s/.*/release 0.0.1/" "$tests_root/tests/request-signatures.txt" | write_file tests/request-signatures.txt

  run_in_repo php scripts/record-request-signatures.php

  assert_equal 0 "$run_status" "the exit code"
  assert_contains "$run_stdout" "tests/request-signatures.txt now records the " "stdout"
  assert_equal "release $version" "$(head -n 1 "$sandbox_repo/tests/request-signatures.txt")" "the first line"
}

test_a_record_of_the_current_version_is_left_alone() {
  prepare_record
  write_file tests/request-signatures.txt <"$tests_root/tests/request-signatures.txt"

  run_in_repo php scripts/record-request-signatures.php

  assert_equal 1 "$run_status" "the exit code"
  assert_contains "$run_stderr" "tests/request-signatures.txt already records $version. Run this after the version bump." "stderr"
  cmp -s "$tests_root/tests/request-signatures.txt" "$sandbox_repo/tests/request-signatures.txt" ||
    fail_test "The refused run changed tests/request-signatures.txt."
}

test_a_moved_parameter_is_refused() {
  prepare_record
  printf '%s\n' 'release 0.0.1' "Services\\TrendsService::list(?string \$region = ...)" | write_file tests/request-signatures.txt

  run_in_repo php scripts/record-request-signatures.php

  assert_equal 1 "$run_status" "the exit code"
  assert_contains "$run_stderr" "Services\\TrendsService::list argument 1 is \$region in 0.0.1, but \$count now." "stderr"
  assert_equal "release 0.0.1" "$(head -n 1 "$sandbox_repo/tests/request-signatures.txt")" "the first line"
}

run_tests
