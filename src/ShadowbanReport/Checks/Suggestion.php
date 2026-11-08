<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ShadowbanReport\Checks;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\ShadowbanReport\Checks\Suggestion\Evidence;
use XTwitterScraper\ShadowbanReport\Checks\Suggestion\Reason;
use XTwitterScraper\ShadowbanVerdict;

/**
 * @phpstan-type SuggestionShape = array{
 *   verdict: ShadowbanVerdict|value-of<ShadowbanVerdict>,
 *   reason: Reason|value-of<Reason>,
 *   evidence: Evidence|array<string,mixed>|null,
 * }
 */
final class Suggestion implements BaseModel
{
    /** @use SdkModel<SuggestionShape> */
    use SdkModel;

    /**
     * Pass means X shows the account there, and fail means it doesn't. Unknown means the check had nothing to test or X didn't answer.
     *
     * @var value-of<ShadowbanVerdict> $verdict
     */
    #[Required(enum: ShadowbanVerdict::class)]
    public string $verdict;

    /**
     * `suggested` means X suggests the account for its username.
     *
     * @var value-of<Reason> $reason
     */
    #[Required(enum: Reason::class)]
    public string $reason;

    /**
     * The username searched & the accounts X suggested.
     */
    #[Required]
    public ?Evidence $evidence;

    /**
     * `new Suggestion()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Suggestion::with(verdict: ..., reason: ..., evidence: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Suggestion)->withVerdict(...)->withReason(...)->withEvidence(...)
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
     * `suggested` means X suggests the account for its username.
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
     * The username searched & the accounts X suggested.
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
