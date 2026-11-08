<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Communities;

use XTwitterScraper\CommunityTopic;
use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type CommunityListTopicsResponseShape = array{
 *   topics: list<CommunityTopic|array<string,mixed>>,
 *   count: int,
 *   message?: string|null,
 * }
 */
final class CommunityListTopicsResponse implements BaseModel
{
    /** @use SdkModel<CommunityListTopicsResponseShape> */
    use SdkModel;

    /**
     * Topics in X's order.
     *
     * @var list<CommunityTopic> $topics
     */
    #[Required(list: CommunityTopic::class)]
    public array $topics;

    /**
     * Top-level topics returned & charged.
     */
    #[Required]
    public int $count;

    /**
     * What to do next. Present only when X lists no topic.
     */
    #[Optional]
    public ?string $message;

    /**
     * `new CommunityListTopicsResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CommunityListTopicsResponse::with(topics: ..., count: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CommunityListTopicsResponse)->withTopics(...)->withCount(...)
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
     * @param list<CommunityTopic|array<string,mixed>> $topics
     */
    public static function with(array $topics, int $count, ?string $message = null): self
    {
        $self = new self;

        $self['topics'] = $topics;
        $self['count'] = $count;

        null !== $message && $self['message'] = $message;

        return $self;
    }

    /**
     * Topics in X's order.
     *
     * @param list<CommunityTopic|array<string,mixed>> $topics
     */
    public function withTopics(array $topics): self
    {
        $self = clone $this;
        $self['topics'] = $topics;

        return $self;
    }

    /**
     * Top-level topics returned & charged.
     */
    public function withCount(int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

        return $self;
    }

    /**
     * What to do next. Present only when X lists no topic.
     */
    public function withMessage(?string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }
}
