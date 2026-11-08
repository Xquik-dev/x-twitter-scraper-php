<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ShadowbanReport\Checks;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\ShadowbanReport\Checks\Replies\Evidence;
use XTwitterScraper\ShadowbanReport\Checks\Replies\Reason;
use XTwitterScraper\ShadowbanVerdict;

/**
 * @phpstan-type RepliesShape = array{
 *   verdict: ShadowbanVerdict|value-of<ShadowbanVerdict>,
 *   reason: Reason|value-of<Reason>,
 *   evidence: Evidence|array<string,mixed>|null,
 * }
 */
final class Replies implements BaseModel
{
    /** @use SdkModel<RepliesShape> */
    use SdkModel;

    /**
     * Pass means X shows the account there, and fail means it doesn't. Unknown means the check had nothing to test or X didn't answer.
     *
     * @var value-of<ShadowbanVerdict> $verdict
     */
    #[Required(enum: ShadowbanVerdict::class)]
    public string $verdict;

    /**
     * `more_replies` means X put a reply behind its hidden replies prompt. `not_found` means no reply showed on the pages the check read.
     *
     * @var value-of<Reason> $reason
     */
    #[Required(enum: Reason::class)]
    public string $reason;

    /**
     * Each reply it opened & where it showed.
     */
    #[Required]
    public ?Evidence $evidence;

    /**
     * `new Replies()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Replies::with(verdict: ..., reason: ..., evidence: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Replies)->withVerdict(...)->withReason(...)->withEvidence(...)
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
     * `more_replies` means X put a reply behind its hidden replies prompt. `not_found` means no reply showed on the pages the check read.
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
     * Each reply it opened & where it showed.
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
