# Contributing

Read [GOVERNANCE.md](GOVERNANCE.md) before proposing major changes.

Follow the shared [Xquik contribution policy][contribution-policy].

## Set Up

Install PHP 8.3 or newer and Composer 2.10.2.

Install the locked development dependencies:

```sh
./scripts/bootstrap
```

Never commit credentials or runtime environment files.

## Generated Code

Most SDK files come from the public OpenAPI contract.

Preserve generated method names and response contracts.

Avoid generated-file changes when a generator fix exists.

Place stable examples outside generated directories.

## Verify Changes

Run focused tests while editing.

Run every gate before requesting review:

```sh
./bin/check-local
```

It installs locked dependencies, then runs PHP CS Fixer, PHPStan, ShellCheck, REUSE, and syntax checks.
Then it runs tests, coverage, dependency audits, the reproducible archive check, and Semgrep.
It stops at the first failure and says what to fix.
It skips REUSE and Semgrep when they are missing, so install both before a release.

For a clean tree whose commit is on GitHub, it posts the `xquik-local-checks` commit status.
Pull requests need that status to merge. Pass `--no-status` to skip posting.

Executable line coverage must remain at least 90%.

Branch coverage must remain at least 80%.

Add regression tests for every corrected defect.

Dynamic coverage measures the runtime core and service facades.

PHPStan validates every generated SDK type.

`TEST_API_BASE_URL` accepts literal loopback IPv4 only.

This guard prevents tests from mutating remote services.

## Submit changes

Use clear Conventional Commit subjects and sign commits with `git commit --signoff`.
Follow the shared [review policy][review-policy].

## Report Security Issues

Never disclose suspected vulnerabilities in public issues.

Follow [SECURITY.md](SECURITY.md) for private reporting.

## Releases

Maintainers release from their own machine, not from GitHub Actions.

After the version and changelog update reaches `main`, run this from a clean `main`:

```sh
./bin/release-local
```

It refuses unless `main` matches `origin/main` and the `v*` tag is new.
It runs `bin/check-local`, audits dependencies, and builds the Composer archive.
Then it pushes the annotated tag, which Packagist reads from GitHub.
Last, it publishes the GitHub release with notes from CHANGELOG.md.

[contribution-policy]: https://github.com/Xquik-dev/.github/blob/main/CONTRIBUTING.md
[review-policy]: https://github.com/Xquik-dev/.github/blob/main/REVIEWING.md

Xquik is an independent third-party service. Not affiliated with X Corp. "Twitter" and "X" are trademarks of X Corp.
