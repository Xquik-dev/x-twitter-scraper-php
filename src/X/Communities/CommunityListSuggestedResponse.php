<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Communities;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Communities\CommunityGetInfoResponse\Community;

/**
 * @phpstan-type CommunityListSuggestedResponseShape = array{
 *   communities: list<Community|array<string,mixed>>,
 *   count: int,
 *   message?: string|null,
 * }
 */
final class CommunityListSuggestedResponse implements BaseModel
{
    /** @use SdkModel<CommunityListSuggestedResponseShape> */
    use SdkModel;

    /**
     * Suggested communities in X's order.
     *
     * @var list<Community> $communities
     */
    #[Required(list: Community::class)]
    public array $communities;

    /**
     * Communities returned & charged.
     */
    #[Required]
    public int $count;

    /**
     * What to do next. Present only when X suggests none.
     */
    #[Optional]
    public ?string $message;

    /**
     * `new CommunityListSuggestedResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CommunityListSuggestedResponse::with(communities: ..., count: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CommunityListSuggestedResponse)->withCommunities(...)->withCount(...)
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
     * @param list<Community|array<string,mixed>> $communities
     */
    public static function with(array $communities, int $count, ?string $message = null): self
    {
        $self = new self;

        $self['communities'] = $communities;
        $self['count'] = $count;

        null !== $message && $self['message'] = $message;

        return $self;
    }

    /**
     * Suggested communities in X's order.
     *
     * @param list<Community|array<string,mixed>> $communities
     */
    public function withCommunities(array $communities): self
    {
        $self = clone $this;
        $self['communities'] = $communities;

        return $self;
    }

    /**
     * Communities returned & charged.
     */
    public function withCount(int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

        return $self;
    }

    /**
     * What to do next. Present only when X suggests none.
     */
    public function withMessage(?string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }
}
