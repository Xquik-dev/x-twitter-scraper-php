# Contributing

Read [GOVERNANCE.md](GOVERNANCE.md) before proposing major changes.

Follow the shared [Xquik contribution policy][contribution-policy].

## Set Up

Install PHP 8.3 or newer with Xdebug, Composer 2.10.2 or newer, uv, Semgrep and ShellCheck.
On macOS, run `brew install php composer uv semgrep shellcheck`, then install Xdebug with PECL.

Install the locked development dependencies.

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

Run every gate before requesting review.

```sh
./bin/check-local
```

It installs locked dependencies, then runs PHP CS Fixer, PHPStan, ShellCheck and the script tests.
Then it runs REUSE 6.2.0 through `uvx`, the platform and syntax checks, tests and coverage.
Last, it runs the dependency audit, the reproducible archive check and Semgrep.
It stops at the first failure and says what to fix.
Semgrep and uv are required, and no check is ever skipped.
Semgrep uses every PHP rule of the semgrep-rules release branch at the commit that `scripts/semgrep` pins.
Any Semgrep finding fails the run, and so does any file that Semgrep cannot parse.
Semgrep 1.180 cannot parse a named argument called `list`, which PHP 8 allows. The run allows that 1 error only where the skipped text is exactly `list:`.
`./scripts/test-scripts` runs the tests of `bin/` and `scripts/` with fake GitHub, Packagist and Composer commands.

For a clean tree whose commit is on GitHub, it posts the `xquik-local-checks` commit status.
Pull requests need that status to merge. Pass `--no-status` to skip posting.

The dependency audit blocks every advisory in a package the SDK ships and every abandoned package.
Severity never excuses a finding, and a Composer ignore rule blocks too.
It also blocks development-only advisories unless `audit-exceptions.json` lists them.
List one only when no fixed release exists, with `advisory`, `path`, `reason` and `recheck`.
Use the reason `build-time only` or `peer dependency provided by the host`.
Set `recheck` at most 30 days out. The entry blocks again on that date or once a fix ships.

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

After the version and changelog update reaches `main`, run this from a clean `main`.

```sh
./bin/release-local --dry-run
./bin/release-local
```

It refuses unless `main` matches `origin/main`, the `v*` tag is new and Packagist lacks the version.
It runs `bin/check-local`, audits dependencies, and builds the Composer archive.
It prints the Packagist listing fields and every file the archive ships.
A dry run stops there and publishes, tags and releases nothing.
A release then pushes the annotated tag, which Packagist reads through its GitHub hook.
Next, it publishes the GitHub release with the archive and notes from CHANGELOG.md.
Last, it waits until Packagist lists the version.
Packagist needs no token, so the release reads no Keychain item.

[contribution-policy]: https://github.com/Xquik-dev/.github/blob/main/CONTRIBUTING.md
[review-policy]: https://github.com/Xquik-dev/.github/blob/main/REVIEWING.md

Xquik is an independent third-party service. Not affiliated with X Corp. "Twitter" and "X" are trademarks of X Corp.
