<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type TweetUserMentionShape = array{
 *   screenName: string,
 *   iDStr?: string|null,
 *   indices?: list<int>|null,
 *   name?: string|null,
 * }
 */
final class TweetUserMention implements BaseModel
{
    /** @use SdkModel<TweetUserMentionShape> */
    use SdkModel;

    #[Required('screen_name')]
    public string $screenName;

    #[Optional('id_str')]
    public ?string $iDStr;

    /**
     * @var list<int>|null $indices
     */
    #[Optional(list: 'int')]
    public ?array $indices;

    #[Optional]
    public ?string $name;

    /**
     * `new TweetUserMention()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetUserMention::with(screenName: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetUserMention)->withScreenName(...)
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
     * @param list<int>|null $indices
     */
    public static function with(string $screenName, ?string $iDStr = null, ?array $indices = null, ?string $name = null): self
    {
        $self = new self;

        $self['screenName'] = $screenName;

        null !== $iDStr && $self['iDStr'] = $iDStr;
        null !== $indices && $self['indices'] = $indices;
        null !== $name && $self['name'] = $name;

        return $self;
    }

    public function withScreenName(string $screenName): self
    {
        $self = clone $this;
        $self['screenName'] = $screenName;

        return $self;
    }

    public function withIDStr(?string $iDStr): self
    {
        $self = clone $this;
        $self['iDStr'] = $iDStr;

        return $self;
    }

    /**
     * @param list<int>|null $indices
     */
    public function withIndices(?array $indices): self
    {
        $self = clone $this;
        $self['indices'] = $indices;

        return $self;
    }

    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }
}
