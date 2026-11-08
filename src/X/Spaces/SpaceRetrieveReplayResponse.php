<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Spaces;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Spaces\SpaceRetrieveReplayResponse\Replay;

/**
 * @phpstan-type SpaceRetrieveReplayResponseShape = array{
 *   replay: Replay|array<string,mixed>,
 * }
 */
final class SpaceRetrieveReplayResponse implements BaseModel
{
    /** @use SdkModel<SpaceRetrieveReplayResponseShape> */
    use SdkModel;

    /**
     * Recording of an ended Space.
     */
    #[Required]
    public Replay $replay;

    /**
     * `new SpaceRetrieveReplayResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SpaceRetrieveReplayResponse::with(replay: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SpaceRetrieveReplayResponse)->withReplay(...)
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
     * @param Replay|array<string,mixed> $replay
     */
    public static function with(Replay|array $replay): self
    {
        $self = new self;

        $self['replay'] = $replay;

        return $self;
    }

    /**
     * Recording of an ended Space.
     *
     * @param Replay|array<string,mixed> $replay
     */
    public function withReplay(Replay|array $replay): self
    {
        $self = clone $this;
        $self['replay'] = $replay;

        return $self;
    }
}
