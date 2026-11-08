<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\SportsGameAudience;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\SportsGameAudience\Chat\OpensIn;

/**
 * @phpstan-type ChatShape = array{
 *   available: bool|null,
 *   broadcastID: string|null,
 *   opensIn: OpensIn|array<string,mixed>|null,
 * }
 */
final class Chat implements BaseModel
{
    /** @use SdkModel<ChatShape> */
    use SdkModel;

    /**
     * Whether the chat is open now.
     */
    #[Required]
    public ?bool $available;

    /**
     * X's ID for the game's chat room.
     */
    #[Required('broadcastId')]
    public ?string $broadcastID;

    /**
     * Time left until the chat opens. Null while it is open & after the game.
     */
    #[Required]
    public ?OpensIn $opensIn;

    /**
     * `new Chat()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Chat::with(available: ..., broadcastID: ..., opensIn: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Chat)->withAvailable(...)->withBroadcastID(...)->withOpensIn(...)
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
     * @param OpensIn|array<string,mixed>|null $opensIn
     */
    public static function with(?bool $available, ?string $broadcastID, OpensIn|array|null $opensIn): self
    {
        $self = new self;

        $self['available'] = $available;
        $self['broadcastID'] = $broadcastID;
        $self['opensIn'] = $opensIn;

        return $self;
    }

    /**
     * Whether the chat is open now.
     */
    public function withAvailable(?bool $available): self
    {
        $self = clone $this;
        $self['available'] = $available;

        return $self;
    }

    /**
     * X's ID for the game's chat room.
     */
    public function withBroadcastID(?string $broadcastID): self
    {
        $self = clone $this;
        $self['broadcastID'] = $broadcastID;

        return $self;
    }

    /**
     * Time left until the chat opens. Null while it is open & after the game.
     *
     * @param OpensIn|array<string,mixed>|null $opensIn
     */
    public function withOpensIn(OpensIn|array|null $opensIn): self
    {
        $self = clone $this;
        $self['opensIn'] = $opensIn;

        return $self;
    }
}
