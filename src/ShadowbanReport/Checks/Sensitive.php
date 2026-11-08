<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ShadowbanReport\Checks;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\ShadowbanReport\Checks\Sensitive\Reason;
use XTwitterScraper\ShadowbanVerdict;

/**
 * @phpstan-type SensitiveShape = array{
 *   verdict: ShadowbanVerdict|value-of<ShadowbanVerdict>,
 *   reason: Reason|value-of<Reason>,
 *   evidence: mixed,
 * }
 */
final class Sensitive implements BaseModel
{
    /** @use SdkModel<SensitiveShape> */
    use SdkModel;

    /**
     * Pass means X shows the account there, and fail means it doesn't. Unknown means the check had nothing to test or X didn't answer.
     *
     * @var value-of<ShadowbanVerdict> $verdict
     */
    #[Required(enum: ShadowbanVerdict::class)]
    public string $verdict;

    /**
     * `unknown` means X left the flag out of the profile.
     *
     * @var value-of<Reason> $reason
     */
    #[Required(enum: Reason::class)]
    public string $reason;

    /**
     * Always null, since the reason holds the answer.
     */
    #[Required]
    public mixed $evidence;

    /**
     * `new Sensitive()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Sensitive::with(verdict: ..., reason: ..., evidence: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Sensitive)->withVerdict(...)->withReason(...)->withEvidence(...)
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
     */
    public static function with(ShadowbanVerdict|string $verdict, Reason|string $reason, mixed $evidence): self
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
     * `unknown` means X left the flag out of the profile.
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
     * Always null, since the reason holds the answer.
     */
    public function withEvidence(mixed $evidence): self
    {
        $self = clone $this;
        $self['evidence'] = $evidence;

        return $self;
    }
}
