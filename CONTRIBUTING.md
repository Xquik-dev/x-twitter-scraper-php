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
./scripts/lint
./scripts/test
./scripts/coverage
./scripts/audit
reuse lint
./scripts/check-reproducible
```

Executable line coverage must remain at least 90%.

Branch coverage must remain at least 80%.

Add regression tests for every corrected defect.

Dynamic coverage measures the runtime core and service facades.

PHPStan validates every generated SDK type.

`TEST_API_BASE_URL` accepts literal loopback IPv4 only.

This guard prevents tests from mutating remote services.

## Submit Changes

Keep pull requests focused.

Explain user-visible behavior and public contract effects.

Link relevant issues and public API contracts.

Use clear Conventional Commit subjects when practical.

Sign every commit with the Developer Certificate of Origin:

```sh
git commit --signoff
```

Another human must review maintainer-authored, nontrivial changes.

Reviewers follow the shared [review policy][review-policy].

Address every review comment before merging.

## Report Security Issues

Never disclose suspected vulnerabilities in public issues.

Follow [SECURITY.md](SECURITY.md) for private reporting.

## Releases

Publish an immutable `v*` release after its commit reaches `main`.

Verify the tag, changelog, audit, licensing, and reproducible archive.

[contribution-policy]: https://github.com/Xquik-dev/.github/blob/main/CONTRIBUTING.md
[review-policy]: https://github.com/Xquik-dev/.github/blob/main/REVIEWING.md

Xquik is an independent third-party service. Not affiliated with X Corp. "Twitter" and "X" are trademarks of X Corp.
