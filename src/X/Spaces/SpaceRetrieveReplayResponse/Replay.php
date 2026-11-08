<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Spaces\SpaceRetrieveReplayResponse;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type ReplayShape = array{
 *   url: string,
 *   streamType?: string|null,
 *   status?: string|null,
 * }
 */
final class Replay implements BaseModel
{
    /** @use SdkModel<ReplayShape> */
    use SdkModel;

    /**
     * HLS playlist of the recording.
     */
    #[Required]
    public string $url;

    /**
     * Stream format, as X names it.
     */
    #[Optional]
    public ?string $streamType;

    /**
     * Stream status, as X names it.
     */
    #[Optional]
    public ?string $status;

    /**
     * `new Replay()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Replay::with(url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Replay)->withUrl(...)
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
    public static function with(string $url, ?string $streamType = null, ?string $status = null): self
    {
        $self = new self;

        $self['url'] = $url;

        null !== $streamType && $self['streamType'] = $streamType;
        null !== $status && $self['status'] = $status;

        return $self;
    }

    /**
     * HLS playlist of the recording.
     */
    public function withUrl(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Stream format, as X names it.
     */
    public function withStreamType(?string $streamType): self
    {
        $self = clone $this;
        $self['streamType'] = $streamType;

        return $self;
    }

    /**
     * Stream status, as X names it.
     */
    public function withStatus(?string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }
}
