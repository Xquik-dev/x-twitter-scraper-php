<?php

declare(strict_types=1);

namespace XTwitterScraper\Styles\StyleGetPerformanceResponse;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type TweetShape = array{
 *   id: string,
 *   text: string,
 *   createdAt?: string|null,
 *   likeCount?: int|null,
 *   replyCount?: int|null,
 *   retweetCount?: int|null,
 *   viewCount?: int|null,
 * }
 */
final class Tweet implements BaseModel
{
    /** @use SdkModel<TweetShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public string $text;

    #[Optional]
    public ?string $createdAt;

    #[Optional]
    public ?int $likeCount;

    #[Optional]
    public ?int $replyCount;

    #[Optional]
    public ?int $retweetCount;

    #[Optional]
    public ?int $viewCount;

    /**
     * `new Tweet()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Tweet::with(id: ..., text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Tweet)->withID(...)->withText(...)
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
    public static function with(
        string $id,
        string $text,
        ?string $createdAt = null,
        ?int $likeCount = null,
        ?int $replyCount = null,
        ?int $retweetCount = null,
        ?int $viewCount = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['text'] = $text;

        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $likeCount && $self['likeCount'] = $likeCount;
        null !== $replyCount && $self['replyCount'] = $replyCount;
        null !== $retweetCount && $self['retweetCount'] = $retweetCount;
        null !== $viewCount && $self['viewCount'] = $viewCount;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    public function withCreatedAt(string $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withLikeCount(int $likeCount): self
    {
        $self = clone $this;
        $self['likeCount'] = $likeCount;

        return $self;
    }

    public function withReplyCount(int $replyCount): self
    {
        $self = clone $this;
        $self['replyCount'] = $replyCount;

        return $self;
    }

    public function withRetweetCount(int $retweetCount): self
    {
        $self = clone $this;
        $self['retweetCount'] = $retweetCount;

        return $self;
    }

    public function withViewCount(int $viewCount): self
    {
        $self = clone $this;
        $self['viewCount'] = $viewCount;

        return $self;
    }
}
