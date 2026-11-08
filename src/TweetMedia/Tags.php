<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\TweetMedia;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type TagsShape = array{
 *   name?: string|null,
 *   screenName?: string|null,
 *   type?: string|null,
 *   userID?: string|null,
 * }
 */
final class Tags implements BaseModel
{
    /** @use SdkModel<TagsShape> */
    use SdkModel;

    #[Optional]
    public ?string $name;

    #[Optional('screen_name')]
    public ?string $screenName;

    #[Optional]
    public ?string $type;

    #[Optional('user_id')]
    public ?string $userID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $name = null, ?string $screenName = null, ?string $type = null, ?string $userID = null): self
    {
        $self = new self;

        null !== $name && $self['name'] = $name;
        null !== $screenName && $self['screenName'] = $screenName;
        null !== $type && $self['type'] = $type;
        null !== $userID && $self['userID'] = $userID;

        return $self;
    }

    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withScreenName(?string $screenName): self
    {
        $self = clone $this;
        $self['screenName'] = $screenName;

        return $self;
    }

    public function withType(?string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    public function withUserID(?string $userID): self
    {
        $self = clone $this;
        $self['userID'] = $userID;

        return $self;
    }
}
