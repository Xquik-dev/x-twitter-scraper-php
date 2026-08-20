# OpenSSF Best Practices Evidence

This register tracks the Gold assessment for this repository.

The official entry is [bestpractices.dev project 13737][badge].

Assessment date: 2026-07-23.

## Eligibility

This public PHP SDK is active and released.

It is eligible for the OpenSSF Best Practices badge.

No OpenSSF-defined ineligibility applies.

## Verified Technical Controls

| Area | Evidence |
| --- | --- |
| License | Apache-2.0 and REUSE 3.3 metadata |
| Contribution process | DCO sign-off and independent review rules |
| Governance | Public roles, decisions, releases, and continuity policy |
| Security reporting | Private reporting, response targets, boundaries, and threat model |
| Runtime compatibility | PHP 8.1 and 8.2 syntax and production dependency checks |
| Functional tests | PHP 8.3, 8.4, and 8.5 |
| Executable line coverage | `./scripts/coverage` enforces 90% |
| Branch coverage | `./scripts/coverage` enforces 80% |
| Static analysis | PHPStan level max and PHP CS Fixer |
| Dependency review | Dependabot, Composer audit, and a license allowlist |
| Licensing gate | Pinned REUSE action checks every repository file |
| Reproducibility | 2 normalized Composer archives must have identical bytes |
| CI | Pull requests and pushes run pinned, least-privilege workflows |
| Two-factor authentication | The Xquik-dev organization requires 2FA |

The suite runs 247 tests with 689 assertions and 7 intentional skips.

It covers 3,887 of 4,052 executable lines, or 95.93%.

It covers 1,059 of 1,282 branches, or 82.61%.

Dynamic coverage includes the client, runtime core, and service facades.

Generated DTO boilerplate does not inflate the dynamic coverage score.

PHPStan checks every generated DTO at its strictest level.

The loopback service suite also parses generated response models.

REUSE validates license metadata for all 962 repository files.

## Outstanding Silver Blocker

The release workflow now creates SLSA provenance for exact Composer archives.

It also attaches each archive and Sigstore bundle to GitHub Releases.

Run one post-merge release and verify its public artifact.

Keep `signed_releases` Unmet until that verification succeeds.

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

Run these evidence commands before releases:

```sh
./scripts/lint
./scripts/test
./scripts/coverage
./scripts/audit
reuse lint
./scripts/check-reproducible
gh attestation verify ARCHIVE \
  --repo Xquik-dev/x-twitter-scraper-php \
  --signer-workflow Xquik-dev/x-twitter-scraper-php/.github/workflows/release-provenance.yml
```

Reassess the register before every major release.

Update bestpractices.dev only with public evidence.

[badge]: https://www.bestpractices.dev/projects/13737

Xquik is an independent third-party service. Not affiliated with X Corp. "Twitter" and "X" are trademarks of X Corp.
