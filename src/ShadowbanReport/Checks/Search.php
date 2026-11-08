<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ShadowbanReport\Checks;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\ShadowbanReport\Checks\Search\Evidence;
use XTwitterScraper\ShadowbanReport\Checks\Search\Reason;
use XTwitterScraper\ShadowbanVerdict;

/**
 * @phpstan-type SearchShape = array{
 *   verdict: ShadowbanVerdict|value-of<ShadowbanVerdict>,
 *   reason: Reason|value-of<Reason>,
 *   evidence: Evidence|array<string,mixed>|null,
 * }
 */
final class Search implements BaseModel
{
    /** @use SdkModel<SearchShape> */
    use SdkModel;

    /**
     * Pass means X shows the account there, and fail means it doesn't. Unknown means the check had nothing to test or X didn't answer.
     *
     * @var value-of<ShadowbanVerdict> $verdict
     */
    #[Required(enum: ShadowbanVerdict::class)]
    public string $verdict;

    /**
     * `listed` means search shows its posts & `missing` means it shows none. `no_recent_posts` means the account has no recent post to look for.
     *
     * @var value-of<Reason> $reason
     */
    #[Required(enum: Reason::class)]
    public string $reason;

    /**
     * The search & the posts it looked for.
     */
    #[Required]
    public ?Evidence $evidence;

    /**
     * `new Search()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Search::with(verdict: ..., reason: ..., evidence: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Search)->withVerdict(...)->withReason(...)->withEvidence(...)
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
     * `listed` means search shows its posts & `missing` means it shows none. `no_recent_posts` means the account has no recent post to look for.
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
     * The search & the posts it looked for.
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
