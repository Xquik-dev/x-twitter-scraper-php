#!/usr/bin/env bash

# SPDX-FileCopyrightText: 2026 Xquik contributors
#
# SPDX-License-Identifier: Apache-2.0

# Runs bin/release-local in a throwaway repository whose origin is a local
# bare repository. Stubs stand in for the checks and the archive build. Fake
# commands stand in for Composer, curl, the GitHub CLI, sleep and the macOS
# Keychain, so no test can reach Packagist, GitHub or a real secret.
# The fake Packagist lists a version once its tag is on the origin, as the
# real one does through its GitHub hook.

set -euo pipefail

# shellcheck source=scripts/tests/support.sh
source "$(dirname -- "${BASH_SOURCE[0]}")/support.sh"

readonly listing="==> Reading the Packagist listing of xquik/x-twitter-scraper 9.9.9
Package         xquik/x-twitter-scraper
Version         9.9.9
Description     Search & export <tweets>.
Keywords        first-keyword, second-keyword
Homepage        https://example.com/
License         Example-License
Support docs    https://example.com/docs
Support issues  https://example.com/issues
Support source  https://example.com/source
Requires        php ^8.1, example/http ^1
==> Listing the files that xquik/x-twitter-scraper 9.9.9 ships
CHANGELOG.md
composer.json
src/Version.php
The Composer archive holds 3 files. Packagist serves the same 3 files from the tag."
readonly shipped_files="CHANGELOG.md
composer.json
src/Version.php"
readonly packagist_url="https://repo.packagist.org/p2/xquik/x-twitter-scraper.json"
readonly release_arguments="--repo Xquik-dev/x-twitter-scraper-php --title v9.9.9 --notes-file NOTES"
readonly release_tags="refs/tags/v9.9.9
refs/tags/v9.9.9^{}"
readonly release_failed_line="Tag v9.9.9 is on origin, but the GitHub release failed. Fix the error above, then build the archive with ./scripts/build-archive and publish it with gh release create v9.9.9 --verify-tag."

# Builds a repository on main that matches its origin, with stand-ins for
# every step that would leave the machine.
prepare_release() {
  local description_line='"description": "Search & export <tweets>.",'
  if [[ -n "${FIXTURE_NO_DESCRIPTION:-}" ]]; then
    description_line=""
  fi
  copy_file bin/release-local
  copy_file scripts/package-listing
  stub bin/check-local <<'EOF'
#!/bin/sh
# Stands in for bin/check-local.
echo "ran" >>"$FAKE_LOGS/check-local"
EOF
  stub scripts/audit <<'EOF'
#!/bin/sh
# Stands in for scripts/audit.
echo "ran" >>"$FAKE_LOGS/audit"
EOF
  stub scripts/build-archive <<'EOF'
#!/bin/sh
# Stands in for the archive build. It packs the files that Git exports, and
# adds 1 more file when FAKE_ARCHIVE_EXTRA is set.
echo "ran" >>"$FAKE_LOGS/build-archive"
git archive --format=zip --output "$1" HEAD
if [ -n "${FAKE_ARCHIVE_EXTRA:-}" ]; then
  echo "extra" >"$TMPDIR/extra.txt"
  (cd "$TMPDIR" && zip -q "$1" extra.txt)
fi
EOF
  write_file composer.json <<EOF
{
  "name": "xquik/x-twitter-scraper",
  $description_line
  "keywords": ["first-keyword", "second-keyword"],
  "homepage": "https://example.com/",
  "license": "Example-License",
  "support": {
    "docs": "https://example.com/docs",
    "issues": "https://example.com/issues",
    "source": "https://example.com/source"
  },
  "require": {
    "php": "^8.1",
    "example/http": "^1"
  }
}
EOF
  write_file src/Version.php <<EOF
<?php

namespace XTwitterScraper;

const VERSION = '${FIXTURE_SDK_VERSION:-9.9.9}';
EOF
  write_file .release-please-manifest.json <<EOF
{
  ".": "${FIXTURE_VERSION:-9.9.9}"
}
EOF
  write_file CHANGELOG.md <<'EOF'
# Changelog

## 9.9.9 (2026-01-01)

* Add the first note.

## [9.9.8](https://example.com/compare/v9.9.7...v9.9.8) (2025-12-01)

* Older note.
EOF
  write_file .gitattributes <<'EOF'
/.gitattributes                export-ignore
/.release-please-manifest.json export-ignore
/bin                           export-ignore
/scripts                       export-ignore
EOF
  fake composer <<'EOF'
#!/bin/sh
# Stands in for Composer. It records its arguments and rejects composer.json
# when FAKE_COMPOSER_INVALID is set.
echo "$*" >>"$FAKE_LOGS/composer"
[ -z "${FAKE_COMPOSER_INVALID:-}" ]
EOF
  fake curl <<'EOF'
#!/bin/sh
# Stands in for Packagist. It lists the version of FAKE_TAG, which is v9.9.9
# unless a test sets it, once that tag is on the origin, after
# FAKE_PACKAGIST_SLOW_CALLS more requests. FAKE_PACKAGIST_LISTS makes it list
# the version from the start, FAKE_PACKAGIST_HOOK_BROKEN never, and
# FAKE_PACKAGIST_DOWN fails every request.
for argument in "$@"; do url="$argument"; done
echo "$url" >>"$FAKE_LOGS/curl"
if [ -n "${FAKE_PACKAGIST_DOWN:-}" ]; then
  echo "The requested URL returned error 503" >&2
  exit 22
fi
tag="${FAKE_TAG:-v9.9.9}"
versions='{"version":"v9.9.8"}'
listed=no
if [ -n "${FAKE_PACKAGIST_LISTS:-}" ]; then
  listed=yes
elif [ -z "${FAKE_PACKAGIST_HOOK_BROKEN:-}" ] &&
  git --git-dir="$FAKE_ORIGIN" rev-parse --quiet --verify "refs/tags/$tag" >/dev/null 2>&1; then
  echo "asked" >>"$FAKE_LOGS/packagist-after-tag"
  asked="$(wc -l <"$FAKE_LOGS/packagist-after-tag")"
  [ "$asked" -le "${FAKE_PACKAGIST_SLOW_CALLS:-0}" ] || listed=yes
fi
[ "$listed" = no ] || versions="{\"version\":\"$tag\"},$versions"
echo "{\"packages\":{\"xquik/x-twitter-scraper\":[$versions]}}"
EOF
  fake gh <<'EOF'
#!/bin/sh
# Stands in for the GitHub CLI. It is signed in unless FAKE_GH_SIGNED_OUT is
# set. The release list holds the draft IDs in FAKE_DRAFT_IDS. Each release
# call is recorded with the files of the archive it uploads and whether the
# tag was on the origin by then. FAKE_GH_RELEASE_FAILS breaks those calls.
case "$1" in
  auth)
    [ -z "${FAKE_GH_SIGNED_OUT:-}" ]
    exit $?
    ;;
  api)
    [ -z "${FAKE_DRAFT_IDS:-}" ] || printf '%b\n' "$FAKE_DRAFT_IDS"
    exit 0
    ;;
esac
line=""
previous=""
for argument in "$@"; do
  if [ "$previous" = "--notes-file" ]; then
    cp "$argument" "$FAKE_LOGS/notes"
    argument="NOTES"
  fi
  case "$argument" in
    */x-twitter-scraper-php-v*.zip)
      unzip -Z1 "$argument" | grep -v '/$' | LC_ALL=C sort >"$FAKE_LOGS/released-archive"
      argument="ARCHIVE/$(basename "$argument")"
      ;;
  esac
  line="$line $argument"
  previous="$argument"
done
if git --git-dir="$FAKE_ORIGIN" rev-parse --quiet --verify "refs/tags/$3" >/dev/null 2>&1; then
  line="$line, tag on origin"
else
  line="$line, no tag on origin"
fi
echo "${line# }" >>"$FAKE_LOGS/gh"
if [ -n "${FAKE_GH_RELEASE_FAILS:-}" ]; then
  echo "HTTP 500" >&2
  exit 1
fi
EOF
  fake sleep <<'EOF'
#!/bin/sh
# Stands in for sleep. It records the pause and returns at once.
echo "$*" >>"$FAKE_LOGS/sleep"
EOF
  use_real_php
  run_env=("FAKE_ORIGIN=$sandbox/origin.git")
  commit_repo
  add_origin
}

origin_tags() {
  sandbox_git ls-remote --tags origin | sed 's/^[^[:space:]]*[[:space:]]*//'
}

assert_nothing_released() {
  assert_equal "" "$(origin_tags)" "the tags on origin"
  assert_equal "" "$(sandbox_git tag --list)" "the tags in the clone"
  assert_equal "" "$(log_of gh)" "the GitHub release calls"
}

test_a_dry_run_prints_the_listing_and_the_files_and_releases_nothing() {
  prepare_release
  remove_tool gh

  run_in_repo bin/release-local --dry-run

  assert_equal "" "$run_stderr" "stderr"
  assert_equal 0 "$run_status" "the exit code"
  assert_ends_with "$run_stdout" "==> Building the Composer archive for xquik/x-twitter-scraper 9.9.9
$listing
Dry run finished. Nothing was published, tagged or released." "stdout"
  assert_contains "$run_stdout" "Packagist does not list xquik/x-twitter-scraper 9.9.9 yet. A release pushes tag v9.9.9, and Packagist reads it from GitHub." "stdout"
  assert_equal "ran" "$(log_of check-local)" "the check runs"
  assert_equal "ran" "$(log_of audit)" "the audit runs"
  assert_equal "validate --strict" "$(log_of composer)" "the Composer calls"
  assert_equal "$packagist_url" "$(log_of curl)" "the Packagist requests"
  assert_equal "" "$(log_of security)" "the Keychain calls"
  assert_nothing_released
}

test_a_dry_run_of_a_version_that_packagist_lists_says_so_and_still_finishes() {
  prepare_release
  run_env+=("FAKE_PACKAGIST_LISTS=1")

  run_in_repo bin/release-local --dry-run

  assert_equal "" "$run_stderr" "stderr"
  assert_equal 0 "$run_status" "the exit code"
  assert_contains "$run_stdout" "Packagist already lists xquik/x-twitter-scraper 9.9.9. A release stops here until the version is bumped." "stdout"
  assert_ends_with "$run_stdout" "$listing
Dry run finished. Nothing was published, tagged or released." "stdout"
  assert_nothing_released
}

test_a_release_pushes_the_tag_then_publishes_the_archive_and_waits_for_packagist() {
  prepare_release

  run_in_repo bin/release-local

  assert_equal "" "$run_stderr" "stderr"
  assert_equal 0 "$run_status" "the exit code"
  assert_contains "$run_stdout" "$listing" "stdout"
  assert_ends_with "$run_stdout" "==> Waiting for Packagist to list xquik/x-twitter-scraper 9.9.9
Released xquik/x-twitter-scraper 9.9.9. Packagist lists it, and GitHub release v9.9.9 holds the archive." "stdout"
  assert_equal "ran" "$(log_of check-local)" "the check runs"
  assert_equal "ran" "$(log_of audit)" "the audit runs"
  assert_equal "$release_tags" "$(origin_tags)" "the tags on origin"
  assert_equal "$(sandbox_git rev-parse HEAD)" "$(sandbox_git rev-parse 'v9.9.9^{commit}')" "the tagged commit"
  assert_equal "release create v9.9.9 ARCHIVE/x-twitter-scraper-php-v9.9.9.zip $release_arguments --verify-tag --latest, tag on origin" \
    "$(log_of gh)" "the GitHub release calls"
  assert_equal "$shipped_files" "$(log_of released-archive)" "the files of the released archive"
  assert_equal "
* Add the first note." "$(log_of notes)" "the release notes"
  assert_equal "$packagist_url
$packagist_url" "$(log_of curl)" "the Packagist requests"
  assert_equal "" "$(log_of sleep)" "the pauses"
}

test_a_release_reads_no_keychain_item_and_needs_no_token_variable() {
  prepare_release

  run_in_repo bin/release-local

  assert_equal 0 "$run_status" "the exit code"
  assert_equal "" "$(log_of security)" "the Keychain calls"
  assert_not_contains "$run_stdout$run_stderr" "KEYCHAIN" "the output"
}

test_a_release_keeps_asking_until_packagist_lists_the_version() {
  prepare_release
  run_env+=("FAKE_PACKAGIST_SLOW_CALLS=2")

  run_in_repo bin/release-local

  assert_equal 0 "$run_status" "the exit code"
  assert_ends_with "$run_stdout" "Released xquik/x-twitter-scraper 9.9.9. Packagist lists it, and GitHub release v9.9.9 holds the archive." "stdout"
  assert_equal "10
10" "$(log_of sleep)" "the pauses"
}

test_a_release_stops_with_the_next_step_when_packagist_never_lists_the_version() {
  prepare_release
  run_env+=("FAKE_PACKAGIST_HOOK_BROKEN=1")

  run_in_repo bin/release-local

  assert_equal 1 "$run_status" "the exit code"
  assert_equal "Packagist does not list xquik/x-twitter-scraper 9.9.9 yet. Tag v9.9.9 and the GitHub release are published. Open https://packagist.org/packages/xquik/x-twitter-scraper, press Update, then check the Packagist hook in the GitHub repository settings." \
    "$run_stderr" "stderr"
  assert_equal "$release_tags" "$(origin_tags)" "the tags on origin"
  assert_contains "$(log_of gh)" "release create v9.9.9" "the GitHub release calls"
  assert_equal 29 "$(log_of sleep | wc -l | tr -d '[:space:]')" "the number of pauses"
}

test_a_release_publishes_the_draft_that_already_exists_for_the_tag() {
  prepare_release
  run_env+=("FAKE_DRAFT_IDS=4242")

  run_in_repo bin/release-local

  assert_equal 0 "$run_status" "the exit code"
  assert_contains "$run_stdout" "==> Publishing the draft GitHub release v9.9.9" "stdout"
  assert_equal "release upload v9.9.9 ARCHIVE/x-twitter-scraper-php-v9.9.9.zip --repo Xquik-dev/x-twitter-scraper-php --clobber, tag on origin
release edit v9.9.9 $release_arguments --draft=false --verify-tag --latest, tag on origin" \
    "$(log_of gh)" "the GitHub release calls"
  assert_equal "$shipped_files" "$(log_of released-archive)" "the files of the released archive"
}

test_a_release_of_a_prerelease_version_is_not_marked_latest() {
  FIXTURE_VERSION="9.9.9-beta.1" FIXTURE_SDK_VERSION="9.9.9-beta.1" prepare_release
  write_file CHANGELOG.md <<'EOF'
# Changelog

## 9.9.9-beta.1 (2026-01-01)

* Add the first note.
EOF
  sandbox_git add --all
  sandbox_git commit --quiet --message "Describe the beta"
  sandbox_git push --quiet origin main
  run_env+=("FAKE_TAG=v9.9.9-beta.1")

  run_in_repo bin/release-local

  assert_equal 0 "$run_status" "the exit code"
  assert_contains "$(log_of gh)" "release create v9.9.9-beta.1 ARCHIVE/x-twitter-scraper-php-v9.9.9-beta.1.zip --repo Xquik-dev/x-twitter-scraper-php --title v9.9.9-beta.1 --notes-file NOTES --verify-tag --prerelease --latest=false, tag on origin" \
    "the GitHub release calls"
}

test_a_failed_github_release_after_the_tag_stops_with_the_way_to_finish_it() {
  prepare_release
  run_env+=("FAKE_GH_RELEASE_FAILS=1")

  run_in_repo bin/release-local

  assert_equal 1 "$run_status" "the exit code"
  assert_equal "HTTP 500
$release_failed_line" "$run_stderr" "stderr"
  assert_equal "$release_tags" "$(origin_tags)" "the tags on origin"
  assert_not_contains "$run_stdout" "Released" "stdout"
}

test_a_release_of_a_version_that_packagist_lists_stops_before_the_checks() {
  prepare_release
  run_env+=("FAKE_PACKAGIST_LISTS=1")

  run_in_repo bin/release-local

  assert_equal 1 "$run_status" "the exit code"
  assert_equal "Packagist already lists xquik/x-twitter-scraper 9.9.9. Bump the version, then rerun." "$run_stderr" "stderr"
  assert_equal "" "$(log_of check-local)" "the check runs"
  assert_nothing_released
}

test_a_packagist_error_stops_the_run_before_the_checks() {
  prepare_release
  run_env+=("FAKE_PACKAGIST_DOWN=1")

  run_in_repo bin/release-local --dry-run

  assert_equal 1 "$run_status" "the exit code"
  assert_equal "The requested URL returned error 503
Packagist did not answer. Check the network, then rerun." "$run_stderr" "stderr"
  assert_equal "" "$(log_of check-local)" "the check runs"
}

test_a_release_without_a_github_login_stops_before_the_checks() {
  prepare_release
  run_env+=("FAKE_GH_SIGNED_OUT=1")

  run_in_repo bin/release-local

  assert_equal 1 "$run_status" "the exit code"
  assert_equal "The GitHub CLI is not signed in. Run gh auth login, then rerun." "$run_stderr" "stderr"
  assert_equal "" "$(log_of check-local)" "the check runs"
  assert_nothing_released
}

test_2_drafts_for_the_tag_stop_the_release() {
  prepare_release
  run_env+=('FAKE_DRAFT_IDS=4242\n4343')

  run_in_repo bin/release-local

  assert_equal 1 "$run_status" "the exit code"
  assert_equal "GitHub has 2 draft releases for v9.9.9. Delete the extra drafts, then rerun." "$run_stderr" "stderr"
  assert_nothing_released
}

test_a_composer_json_that_fails_the_publish_rules_stops_before_the_build() {
  prepare_release
  run_env+=("FAKE_COMPOSER_INVALID=1")

  run_in_repo bin/release-local

  assert_equal 1 "$run_status" "the exit code"
  assert_equal "composer.json fails the Packagist publish rules. Fix the errors above, then rerun." "$run_stderr" "stderr"
  assert_equal "" "$(log_of build-archive)" "the archive builds"
  assert_nothing_released
}

test_an_archive_that_differs_from_the_github_export_stops_the_run() {
  prepare_release
  run_env+=("FAKE_ARCHIVE_EXTRA=1")

  run_in_repo bin/release-local

  assert_equal 1 "$run_status" "the exit code"
  assert_equal "Only one of the Composer archive and the GitHub export holds these files.
extra.txt
The Composer archive and the GitHub export of the tag differ. Align archive.exclude in composer.json with export-ignore in .gitattributes, then rerun." \
    "$run_stderr" "stderr"
  assert_nothing_released
}

test_a_composer_json_without_a_description_stops_the_run() {
  FIXTURE_NO_DESCRIPTION=1 prepare_release

  run_in_repo bin/release-local --dry-run

  assert_equal 1 "$run_status" "the exit code"
  assert_equal "composer.json has no description. Packagist shows it on the package page. Add it, then rerun." \
    "$run_stderr" "stderr"
  assert_not_contains "$run_stdout" "Dry run finished." "stdout"
}

test_a_tag_that_origin_already_has_stops_the_run() {
  prepare_release
  sandbox_git tag --annotate v9.9.9 --message v9.9.9
  sandbox_git push --quiet origin refs/tags/v9.9.9
  sandbox_git tag --delete v9.9.9 >/dev/null

  run_in_repo bin/release-local --dry-run

  assert_equal 1 "$run_status" "the exit code"
  assert_equal "Tag v9.9.9 already exists on origin. Bump the version, then rerun." "$run_stderr" "stderr"
  assert_equal "" "$(log_of check-local)" "the check runs"
}

test_a_tag_that_only_this_clone_has_stops_the_run() {
  prepare_release
  sandbox_git tag --annotate v9.9.9 --message v9.9.9

  run_in_repo bin/release-local

  assert_equal 1 "$run_status" "the exit code"
  assert_equal "Tag v9.9.9 exists only in this clone. Delete it with git tag -d v9.9.9, then rerun." "$run_stderr" "stderr"
  assert_equal "" "$(origin_tags)" "the tags on origin"
}

test_a_working_tree_with_changes_stops_the_run() {
  prepare_release
  write_file untracked.txt <<'EOF'
A change.
EOF

  run_in_repo bin/release-local --dry-run

  assert_equal 1 "$run_status" "the exit code"
  assert_equal "The working tree has changes. Commit or remove them, then rerun." "$run_stderr" "stderr"
  assert_equal "" "$(log_of check-local)" "the check runs"
}

test_a_branch_other_than_main_stops_the_run() {
  prepare_release
  sandbox_git switch --quiet --create topic

  run_in_repo bin/release-local --dry-run

  assert_equal 1 "$run_status" "the exit code"
  assert_equal "The current branch is not main. Switch to main, then rerun." "$run_stderr" "stderr"
}

test_a_main_that_origin_lacks_stops_the_run() {
  prepare_release
  write_file extra.txt <<'EOF'
A commit that origin lacks.
EOF
  sandbox_git add --all
  sandbox_git commit --quiet --message "Add a file"

  run_in_repo bin/release-local --dry-run

  assert_equal 1 "$run_status" "the exit code"
  assert_equal "main differs from origin/main. Pull or push main, then rerun." "$run_stderr" "stderr"
}

test_a_version_without_a_changelog_section_stops_the_run() {
  prepare_release
  write_file CHANGELOG.md <<'EOF'
# Changelog

## 9.9.8 (2025-12-01)

* Older note.
EOF
  sandbox_git add --all
  sandbox_git commit --quiet --message "Drop the changelog section"
  sandbox_git push --quiet origin main

  run_in_repo bin/release-local --dry-run

  assert_equal 1 "$run_status" "the exit code"
  assert_equal "CHANGELOG.md has no section for 9.9.9. Add one, then rerun." "$run_stderr" "stderr"
}

test_a_version_file_that_disagrees_with_the_manifest_stops_the_run() {
  FIXTURE_SDK_VERSION="9.9.8" prepare_release

  run_in_repo bin/release-local --dry-run

  assert_equal 1 "$run_status" "the exit code"
  assert_equal "The manifest says 9.9.9 but src/Version.php says 9.9.8. Align them, then rerun." "$run_stderr" "stderr"
}

test_an_unknown_option_stops_with_the_usage_line() {
  prepare_release

  run_in_repo bin/release-local --force

  assert_equal 2 "$run_status" "the exit code"
  assert_equal "Unknown option --force. Run bin/release-local or bin/release-local --dry-run." "$run_stderr" "stderr"
}

run_tests
