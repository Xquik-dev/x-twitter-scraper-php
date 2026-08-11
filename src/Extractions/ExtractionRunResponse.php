<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Extractions;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type ExtractionRunResponseShape = array{
 *   allowed: bool,
 *   creditsAvailable: string,
 *   creditsRequired: string,
 *   estimatedResults: int,
 *   source: string,
 *   resolvedXUserID?: string|null,
 * }
 */
final class ExtractionRunResponse implements BaseModel
{
    /** @use SdkModel<ExtractionRunResponseShape> */
    use SdkModel;

    #[Required]
    public bool $allowed;

    #[Required]
    public string $creditsAvailable;

    #[Required]
    public string $creditsRequired;

    #[Required]
    public int $estimatedResults;

    #[Required]
    public string $source;

    #[Optional('resolvedXUserId')]
    public ?string $resolvedXUserID;

    /**
     * `new ExtractionRunResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ExtractionRunResponse::with(
     *   allowed: ...,
     *   creditsAvailable: ...,
     *   creditsRequired: ...,
     *   estimatedResults: ...,
     *   source: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ExtractionRunResponse)
     *   ->withAllowed(...)
     *   ->withCreditsAvailable(...)
     *   ->withCreditsRequired(...)
     *   ->withEstimatedResults(...)
     *   ->withSource(...)
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
     */
    public static function with(
        bool $allowed,
        string $creditsAvailable,
        string $creditsRequired,
        int $estimatedResults,
        string $source,
        ?string $resolvedXUserID = null,
    ): self {
        $self = new self;

        $self['allowed'] = $allowed;
        $self['creditsAvailable'] = $creditsAvailable;
        $self['creditsRequired'] = $creditsRequired;
        $self['estimatedResults'] = $estimatedResults;
        $self['source'] = $source;

        null !== $resolvedXUserID && $self['resolvedXUserID'] = $resolvedXUserID;

        return $self;
    }

    public function withAllowed(bool $allowed): self
    {
        $self = clone $this;
        $self['allowed'] = $allowed;

        return $self;
    }

    public function withCreditsAvailable(string $creditsAvailable): self
    {
        $self = clone $this;
        $self['creditsAvailable'] = $creditsAvailable;

        return $self;
    }

    public function withCreditsRequired(string $creditsRequired): self
    {
        $self = clone $this;
        $self['creditsRequired'] = $creditsRequired;

        return $self;
    }

    public function withEstimatedResults(int $estimatedResults): self
    {
        $self = clone $this;
        $self['estimatedResults'] = $estimatedResults;

        return $self;
    }

    public function withSource(string $source): self
    {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }

    public function withResolvedXUserID(string $resolvedXUserID): self
    {
        $self = clone $this;
        $self['resolvedXUserID'] = $resolvedXUserID;

        return $self;
    }
}
