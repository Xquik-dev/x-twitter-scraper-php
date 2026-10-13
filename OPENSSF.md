# OpenSSF Best Practices Evidence

This register tracks the Gold assessment for this repository.

The official entry is [bestpractices.dev project 13737][badge].

The assessment date is 2026-07-23.

## Eligibility

This active, public PHP SDK qualifies for the OpenSSF Best Practices badge.

## Verified Technical Controls

| Area | Evidence |
| --- | --- |
| License | Apache-2.0 and REUSE 3.3 metadata |
| Contribution process | DCO sign-off and `bin/check-local` before every merge |
| Governance | Public roles, decisions, releases, and continuity policy |
| Security reporting | Private reporting, response targets, boundaries, and threat model |
| Runtime compatibility | PHPStan targets PHP 8.1, and `bin/check-local` lints `src` with any installed PHP 8.1 or 8.2 |
| Functional tests | `./scripts/test` on PHP 8.3 or newer |
| Executable line coverage | `./scripts/coverage` enforces 90% |
| Branch coverage | `./scripts/coverage` enforces 80% |
| Static analysis | PHPStan level max and PHP CS Fixer |
| Dependency review | Composer audit at every severity with reviewed development-only exceptions, abandoned package checks, and a license allowlist |
| Code scanning | Semgrep runs every PHP rule of a pinned semgrep-rules release commit and blocks on any finding or any file it cannot parse |
| Licensing gate | REUSE 6.2.0 through `uvx` checks every repository file |
| Reproducibility | 2 normalized Composer archives must have identical bytes |
| Local gate | `bin/check-local` runs every check before review and release, and script tests cover it |
| Two-factor authentication | The Xquik-dev organization requires 2FA |

The suite runs 247 tests with 689 assertions and 7 intentional skips.

It covers 3,887 of 4,052 executable lines, or 95.93%.

It covers 1,059 of 1,282 branches, or 82.61%.

Dynamic coverage includes the client, runtime core, and service facades.

Generated DTO boilerplate does not inflate the dynamic coverage score.

PHPStan checks every generated DTO at its strictest level.

The loopback service suite also parses generated response models.

REUSE validates license metadata for all 969 repository files.

## Release Provenance

Release v0.13.2 provides an attested Composer archive and Sigstore bundle.
Its tag targets commit `66eb960e5324007f28792e5b4e5c99456005ece3`.
GitHub verifies that archive against the former release workflow and hosted-runner policy.

Later releases come from `bin/release-local` on a maintainer machine.
Anyone can rebuild a release archive from its tag and compare the bytes.

## Outstanding Gold Blockers

Human and organizational evidence remains incomplete.

Do not claim Gold while any mandatory criterion remains unmet.

| Gold Requirement | Current Evidence | Required Action |
| --- | --- | --- |
| Access continuity | Public evidence does not prove 2 release-capable maintainers | Grant and verify another maintainer's access |
| Bus factor | Git history shows one significant contributor | Add another significant contributor |
| Unassociated contributors | Fewer than 2 qualifying contributors are independent | Accept qualifying external contributions |
| Independent review | History does not prove 50% qualifying review coverage | Require and record independent reviews |
| Human security review | No completed review exists within 5 years | Commission and publish a scoped review |

Gold eligibility still requires review by a different human.

## Maintenance

Run every evidence check before releases.

```sh
./bin/check-local
```

Reassess the register before every major release.

Update bestpractices.dev only with public evidence.

[badge]: https://www.bestpractices.dev/projects/13737

Xquik is an independent third-party service. Not affiliated with X Corp. "Twitter" and "X" are trademarks of X Corp.
