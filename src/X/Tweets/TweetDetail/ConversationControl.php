<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetDetail;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type ConversationControlShape = array{
 *   allowedCountryCodes?: list<string>|null,
 *   inviteViaMention?: bool|null,
 *   mode?: string|null,
 *   ownerID?: string|null,
 *   ownerUsername?: string|null,
 *   policy?: string|null,
 * }
 */
final class ConversationControl implements BaseModel
{
    /** @use SdkModel<ConversationControlShape> */
    use SdkModel;

    /**
     * Regions whose accounts may reply, as country codes. Sent with the `country_of_origin` mode.
     *
     * @var list<string>|null $allowedCountryCodes
     */
    #[Optional(list: 'string')]
    public ?array $allowedCountryCodes;

    #[Optional]
    public ?bool $inviteViaMention;

    /**
     * Reply policy from X's newer field, such as `my_network`, `premium` or `country_of_origin`. Omitted when X sends none.
     */
    #[Optional]
    public ?string $mode;

    /**
     * The conversation owner's account ID.
     */
    #[Optional('ownerId')]
    public ?string $ownerID;

    #[Optional]
    public ?string $ownerUsername;

    #[Optional]
    public ?string $policy;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $allowedCountryCodes
     */
    public static function with(?array $allowedCountryCodes = null, ?bool $inviteViaMention = null, ?string $mode = null, ?string $ownerID = null, ?string $ownerUsername = null, ?string $policy = null): self
    {
        $self = new self;

        null !== $allowedCountryCodes && $self['allowedCountryCodes'] = $allowedCountryCodes;
        null !== $inviteViaMention && $self['inviteViaMention'] = $inviteViaMention;
        null !== $mode && $self['mode'] = $mode;
        null !== $ownerID && $self['ownerID'] = $ownerID;
        null !== $ownerUsername && $self['ownerUsername'] = $ownerUsername;
        null !== $policy && $self['policy'] = $policy;

        return $self;
    }

    /**
     * Regions whose accounts may reply, as country codes. Sent with the `country_of_origin` mode.
     *
     * @param list<string>|null $allowedCountryCodes
     */
    public function withAllowedCountryCodes(?array $allowedCountryCodes): self
    {
        $self = clone $this;
        $self['allowedCountryCodes'] = $allowedCountryCodes;

        return $self;
    }

    public function withInviteViaMention(?bool $inviteViaMention): self
    {
        $self = clone $this;
        $self['inviteViaMention'] = $inviteViaMention;

        return $self;
    }

    /**
     * Reply policy from X's newer field, such as `my_network`, `premium` or `country_of_origin`. Omitted when X sends none.
     */
    public function withMode(?string $mode): self
    {
        $self = clone $this;
        $self['mode'] = $mode;

        return $self;
    }

    /**
     * The conversation owner's account ID.
     */
    public function withOwnerID(?string $ownerID): self
    {
        $self = clone $this;
        $self['ownerID'] = $ownerID;

        return $self;
    }

    public function withOwnerUsername(?string $ownerUsername): self
    {
        $self = clone $this;
        $self['ownerUsername'] = $ownerUsername;

        return $self;
    }

    public function withPolicy(?string $policy): self
    {
        $self = clone $this;
        $self['policy'] = $policy;

        return $self;
    }
}
