<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Broadcasts;

use XTwitterScraper\Broadcast;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type BroadcastRetrieveResponseShape = array{
 *   broadcast: Broadcast|array<string,mixed>,
 * }
 */
final class BroadcastRetrieveResponse implements BaseModel
{
    /** @use SdkModel<BroadcastRetrieveResponseShape> */
    use SdkModel;

    /**
     * X broadcast, a live video.
     */
    #[Required]
    public Broadcast $broadcast;

    /**
     * `new BroadcastRetrieveResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BroadcastRetrieveResponse::with(broadcast: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BroadcastRetrieveResponse)->withBroadcast(...)
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
     * @param Broadcast|array<string,mixed> $broadcast
     */
    public static function with(Broadcast|array $broadcast): self
    {
        $self = new self;

        $self['broadcast'] = $broadcast;

        return $self;
    }

    /**
     * X broadcast, a live video.
     *
     * @param Broadcast|array<string,mixed> $broadcast
     */
    public function withBroadcast(Broadcast|array $broadcast): self
    {
        $self = clone $this;
        $self['broadcast'] = $broadcast;

        return $self;
    }
}
