<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\FollowerAudit\ArrivalBands;
use XTwitterScraper\FollowerAudit\Classes;
use XTwitterScraper\FollowerAudit\Cohorts;
use XTwitterScraper\FollowerAudit\Coverage;
use XTwitterScraper\FollowerAudit\Quality;
use XTwitterScraper\FollowerAudit\Signals;
use XTwitterScraper\FollowerAudit\Verified;

/**
 * @phpstan-type FollowerAuditShape = array{
 *   account: UserInsights|array<string,mixed>,
 *   coverage: Coverage|array<string,mixed>,
 *   quality: Quality|array<string,mixed>,
 *   classes: list<Classes|array<string,mixed>>,
 *   signals: list<Signals|array<string,mixed>>,
 *   arrivalBands: list<ArrivalBands|array<string,mixed>>,
 *   cohorts: list<Cohorts|array<string,mixed>>,
 *   languages: list<FollowerValueCount|array<string,mixed>>,
 *   places: list<FollowerValueCount|array<string,mixed>>,
 *   verified: Verified|array<string,mixed>,
 *   followers: list<AuditedFollower|array<string,mixed>>,
 *   topFollowers: list<AuditedFollower|array<string,mixed>>,
 * }
 */
final class FollowerAudit implements BaseModel
{
    /** @use SdkModel<FollowerAuditShape> */
    use SdkModel;

    /**
     * Engagement insights of 1 profile. Engagements are likes, replies, reposts and quotes. A rate is null when nothing divides it, such as a profile without posts of its own.
     */
    #[Required]
    public UserInsights $account;

    #[Required]
    public Coverage $coverage;

    #[Required]
    public Quality $quality;

    /**
     * @var list<Classes> $classes
     */
    #[Required(list: Classes::class)]
    public array $classes;

    /**
     * @var list<Signals> $signals
     */
    #[Required(list: Signals::class)]
    public array $signals;

    /**
     * Likely fake share by position in the newest-first list.
     *
     * @var list<ArrivalBands> $arrivalBands
     */
    #[Required(list: ArrivalBands::class)]
    public array $arrivalBands;

    /**
     * Followers who joined X in the same UTC week.
     *
     * @var list<Cohorts> $cohorts
     */
    #[Required(list: Cohorts::class)]
    public array $cohorts;

    /**
     * @var list<FollowerValueCount> $languages
     */
    #[Required(list: FollowerValueCount::class)]
    public array $languages;

    /**
     * @var list<FollowerValueCount> $places
     */
    #[Required(list: FollowerValueCount::class)]
    public array $places;

    #[Required]
    public Verified $verified;

    /**
     * @var list<AuditedFollower> $followers
     */
    #[Required(list: AuditedFollower::class)]
    public array $followers;

    /**
     * @var list<AuditedFollower> $topFollowers
     */
    #[Required(list: AuditedFollower::class)]
    public array $topFollowers;

    /**
     * `new FollowerAudit()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FollowerAudit::with(account: ..., coverage: ..., quality: ..., classes: ..., signals: ..., arrivalBands: ..., cohorts: ..., languages: ..., places: ..., verified: ..., followers: ..., topFollowers: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FollowerAudit)->withAccount(...)->withCoverage(...)->withQuality(...)->withClasses(...)->withSignals(...)->withArrivalBands(...)->withCohorts(...)->withLanguages(...)->withPlaces(...)->withVerified(...)->withFollowers(...)->withTopFollowers(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param UserInsights|array<string,mixed> $account
     * @param Coverage|array<string,mixed> $coverage
     * @param Quality|array<string,mixed> $quality
     * @param list<Classes|array<string,mixed>> $classes
     * @param list<Signals|array<string,mixed>> $signals
     * @param list<ArrivalBands|array<string,mixed>> $arrivalBands
     * @param list<Cohorts|array<string,mixed>> $cohorts
     * @param list<FollowerValueCount|array<string,mixed>> $languages
     * @param list<FollowerValueCount|array<string,mixed>> $places
     * @param Verified|array<string,mixed> $verified
     * @param list<AuditedFollower|array<string,mixed>> $followers
     * @param list<AuditedFollower|array<string,mixed>> $topFollowers
     */
    public static function with(UserInsights|array $account, Coverage|array $coverage, Quality|array $quality, array $classes, array $signals, array $arrivalBands, array $cohorts, array $languages, array $places, Verified|array $verified, array $followers, array $topFollowers): self
    {
        $self = new self;

        $self['account'] = $account;
        $self['coverage'] = $coverage;
        $self['quality'] = $quality;
        $self['classes'] = $classes;
        $self['signals'] = $signals;
        $self['arrivalBands'] = $arrivalBands;
        $self['cohorts'] = $cohorts;
        $self['languages'] = $languages;
        $self['places'] = $places;
        $self['verified'] = $verified;
        $self['followers'] = $followers;
        $self['topFollowers'] = $topFollowers;

        return $self;
    }

    /**
     * Engagement insights of 1 profile. Engagements are likes, replies, reposts and quotes. A rate is null when nothing divides it, such as a profile without posts of its own.
     *
     * @param UserInsights|array<string,mixed> $account
     */
    public function withAccount(UserInsights|array $account): self
    {
        $self = clone $this;
        $self['account'] = $account;

        return $self;
    }

    /**
     * @param Coverage|array<string,mixed> $coverage
     */
    public function withCoverage(Coverage|array $coverage): self
    {
        $self = clone $this;
        $self['coverage'] = $coverage;

        return $self;
    }

    /**
     * @param Quality|array<string,mixed> $quality
     */
    public function withQuality(Quality|array $quality): self
    {
        $self = clone $this;
        $self['quality'] = $quality;

        return $self;
    }

    /**
     * @param list<Classes|array<string,mixed>> $classes
     */
    public function withClasses(array $classes): self
    {
        $self = clone $this;
        $self['classes'] = $classes;

        return $self;
    }

    /**
     * @param list<Signals|array<string,mixed>> $signals
     */
    public function withSignals(array $signals): self
    {
        $self = clone $this;
        $self['signals'] = $signals;

        return $self;
    }

    /**
     * Likely fake share by position in the newest-first list.
     *
     * @param list<ArrivalBands|array<string,mixed>> $arrivalBands
     */
    public function withArrivalBands(array $arrivalBands): self
    {
        $self = clone $this;
        $self['arrivalBands'] = $arrivalBands;

        return $self;
    }

    /**
     * Followers who joined X in the same UTC week.
     *
     * @param list<Cohorts|array<string,mixed>> $cohorts
     */
    public function withCohorts(array $cohorts): self
    {
        $self = clone $this;
        $self['cohorts'] = $cohorts;

        return $self;
    }

    /**
     * @param list<FollowerValueCount|array<string,mixed>> $languages
     */
    public function withLanguages(array $languages): self
    {
        $self = clone $this;
        $self['languages'] = $languages;

        return $self;
    }

    /**
     * @param list<FollowerValueCount|array<string,mixed>> $places
     */
    public function withPlaces(array $places): self
    {
        $self = clone $this;
        $self['places'] = $places;

        return $self;
    }

    /**
     * @param Verified|array<string,mixed> $verified
     */
    public function withVerified(Verified|array $verified): self
    {
        $self = clone $this;
        $self['verified'] = $verified;

        return $self;
    }

    /**
     * @param list<AuditedFollower|array<string,mixed>> $followers
     */
    public function withFollowers(array $followers): self
    {
        $self = clone $this;
        $self['followers'] = $followers;

        return $self;
    }

    /**
     * @param list<AuditedFollower|array<string,mixed>> $topFollowers
     */
    public function withTopFollowers(array $topFollowers): self
    {
        $self = clone $this;
        $self['topFollowers'] = $topFollowers;

        return $self;
    }
}
