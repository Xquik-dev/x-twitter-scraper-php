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

It installs locked dependencies and compares the SDK's fields with the API spec, then runs PHP CS Fixer, PHPStan, ShellCheck and the script tests.
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

## API fields

The check right after the dependency install fails when the SDK's fields differ from the API spec.
Run it alone with `./scripts/api-fields`. It reads the installed classes, so it needs `vendor` and no server.

For each operation in the API spec, it reads the request each class in `src/Services` builds and the params and response types that request names, then compares their fields with the spec's query parameters, JSON body and JSON response.
It reads the spec's fields through `$ref`, `allOf`, `oneOf` and `anyOf`.
Path parameters, header parameters, free-form objects and fields under an object that allows extra properties stay out.
A field missing on 1 side counts once, at its top position.

Each difference prints as 1 line with the method, the full path, `request` or `response`, a kind and the field's JSON path.

```text
GET /api/v1/monitors response enum monitors[].eventTypes[]
```

- `missing` means the spec has the field and the SDK does not. Add it to the SDK.
- `extra` means the SDK has a field the spec does not list. Keep it when callers may use it, and accept it.
- `enum` means both sides list values and the values differ. Add the missing values, and accept values the SDK keeps.
- `required` means the spec's required list and the property's `Required` or `Optional` attribute differ. Fix it only when the change keeps old calls and old responses working.
- `nullable` means the spec and the property's null handling differ.

An operation in the spec that the SDK lacks fails as well. Add it, or list it in `excluded-operations.json` with a reason.
Fixes stay additive. Never remove or rename a public field or parameter to satisfy the check. Accept it instead.

`accepted-field-differences.json` holds the differences the SDK keeps, in groups with a non-empty `reason`.
A difference appears at most once.
An accepted line the check no longer finds fails as stale, so remove it in the change that fixes it.

```json
[
  {
    "reason": "Deprecated alias of minLikes, which the API still reads. The SDK keeps it so existing calls still run.",
    "differences": ["GET /api/v1/x/tweets/search request extra minFaves"]
  }
]
```

Set `XQUIK_OPENAPI_SPEC` to a local copy of the spec to check against it. Pass `--list` to print every difference without failing.

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
