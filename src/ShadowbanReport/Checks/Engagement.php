<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ShadowbanReport\Checks;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\ShadowbanReport\Checks\Engagement\Evidence;
use XTwitterScraper\ShadowbanReport\Checks\Engagement\Reason;
use XTwitterScraper\ShadowbanVerdict;

/**
 * @phpstan-type EngagementShape = array{
 *   verdict: ShadowbanVerdict|value-of<ShadowbanVerdict>,
 *   reason: Reason|value-of<Reason>,
 *   evidence: Evidence|array<string,mixed>|null,
 * }
 */
final class Engagement implements BaseModel
{
    /** @use SdkModel<EngagementShape> */
    use SdkModel;

    /**
     * Pass means X shows the account there, and fail means it doesn't. Unknown means the check had nothing to test or X didn't answer.
     *
     * @var value-of<ShadowbanVerdict> $verdict
     */
    #[Required(enum: ShadowbanVerdict::class)]
    public string $verdict;

    /**
     * `too_few_posts` means fewer than 8 posts to compare, or earlier posts with no engagement.
     *
     * @var value-of<Reason> $reason
     */
    #[Required(enum: Reason::class)]
    public string $reason;

    /**
     * The 2 medians & how many posts each one covers.
     */
    #[Required]
    public ?Evidence $evidence;

    /**
     * `new Engagement()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Engagement::with(verdict: ..., reason: ..., evidence: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Engagement)->withVerdict(...)->withReason(...)->withEvidence(...)
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
     * @param ShadowbanVerdict|value-of<ShadowbanVerdict> $verdict
     * @param Reason|value-of<Reason> $reason
     * @param Evidence|array<string,mixed>|null $evidence
     */
    public static function with(ShadowbanVerdict|string $verdict, Reason|string $reason, Evidence|array|null $evidence): self
    {
        $self = new self;

        $self['verdict'] = $verdict;
        $self['reason'] = $reason;
        $self['evidence'] = $evidence;

        return $self;
    }

    /**
     * Pass means X shows the account there, and fail means it doesn't. Unknown means the check had nothing to test or X didn't answer.
     *
     * @param ShadowbanVerdict|value-of<ShadowbanVerdict> $verdict
     */
    public function withVerdict(ShadowbanVerdict|string $verdict): self
    {
        $self = clone $this;
        $self['verdict'] = $verdict;

        return $self;
    }

    /**
     * `too_few_posts` means fewer than 8 posts to compare, or earlier posts with no engagement.
     *
     * @param Reason|value-of<Reason> $reason
     */
    public function withReason(Reason|string $reason): self
    {
        $self = clone $this;
        $self['reason'] = $reason;

        return $self;
    }

    /**
     * The 2 medians & how many posts each one covers.
     *
     * @param Evidence|array<string,mixed>|null $evidence
     */
    public function withEvidence(Evidence|array|null $evidence): self
    {
        $self = clone $this;
        $self['evidence'] = $evidence;

        return $self;
    }
}
