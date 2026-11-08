<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type UserLiveStatusShape = array{
 *   live: bool,
 *   broadcast: Broadcast|array<string,mixed>|null,
 *   userID: string,
 *   userName: string,
 * }
 */
final class UserLiveStatus implements BaseModel
{
    /** @use SdkModel<UserLiveStatusShape> */
    use SdkModel;

    /**
     * True while the user's latest broadcast is running.
     */
    #[Required]
    public bool $live;

    /**
     * Latest broadcast, live or ended. Null when X shows none. Holds only its ID & state when X can't read it in full.
     */
    #[Required]
    public ?Broadcast $broadcast;

    /**
     * ID of the user.
     */
    #[Required('userId')]
    public string $userID;

    /**
     * Username of the user.
     */
    #[Required]
    public string $userName;

    /**
     * `new UserLiveStatus()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserLiveStatus::with(live: ..., broadcast: ..., userID: ..., userName: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserLiveStatus)->withLive(...)->withBroadcast(...)->withUserID(...)->withUserName(...)
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
     * @param Broadcast|array<string,mixed>|null $broadcast
     */
    public static function with(bool $live, Broadcast|array|null $broadcast, string $userID, string $userName): self
    {
        $self = new self;

        $self['live'] = $live;
        $self['broadcast'] = $broadcast;
        $self['userID'] = $userID;
        $self['userName'] = $userName;

        return $self;
    }

    /**
     * True while the user's latest broadcast is running.
     */
    public function withLive(bool $live): self
    {
        $self = clone $this;
        $self['live'] = $live;

        return $self;
    }

    /**
     * Latest broadcast, live or ended. Null when X shows none. Holds only its ID & state when X can't read it in full.
     *
     * @param Broadcast|array<string,mixed>|null $broadcast
     */
    public function withBroadcast(Broadcast|array|null $broadcast): self
    {
        $self = clone $this;
        $self['broadcast'] = $broadcast;

        return $self;
    }

    /**
     * ID of the user.
     */
    public function withUserID(string $userID): self
    {
        $self = clone $this;
        $self['userID'] = $userID;

        return $self;
    }

    /**
     * Username of the user.
     */
    public function withUserName(string $userName): self
    {
        $self = clone $this;
        $self['userName'] = $userName;

        return $self;
    }
}
