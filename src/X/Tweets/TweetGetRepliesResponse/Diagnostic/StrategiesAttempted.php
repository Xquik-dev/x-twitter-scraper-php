<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetGetRepliesResponse\Diagnostic;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Tweets\TweetGetRepliesResponse\Diagnostic\StrategiesAttempted\StopReason;

/**
 * @phpstan-type StrategiesAttemptedShape = array{
 *   name: string,
 *   newDirectReplies: int,
 *   newNestedReplies: int,
 *   pagesAttempted: int,
 *   stopReason: StopReason|value-of<StopReason>,
 *   newDirectReplyPages?: list<int>|null,
 * }
 */
final class StrategiesAttempted implements BaseModel
{
    /** @use SdkModel<StrategiesAttemptedShape> */
    use SdkModel;

    #[Required]
    public string $name;

    #[Required]
    public int $newDirectReplies;

    #[Required]
    public int $newNestedReplies;

    #[Required]
    public int $pagesAttempted;

    /** @var value-of<StopReason> $stopReason */
    #[Required(enum: StopReason::class)]
    public string $stopReason;

    /**
     * The page, from 1, where each new direct reply appeared.
     *
     * @var list<int>|null $newDirectReplyPages
     */
    #[Optional(list: 'int')]
    public ?array $newDirectReplyPages;

    /**
     * `new StrategiesAttempted()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * StrategiesAttempted::with(
     *   name: ...,
     *   newDirectReplies: ...,
     *   newNestedReplies: ...,
     *   pagesAttempted: ...,
     *   stopReason: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new StrategiesAttempted)
     *   ->withName(...)
     *   ->withNewDirectReplies(...)
     *   ->withNewNestedReplies(...)
     *   ->withPagesAttempted(...)
     *   ->withStopReason(...)
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
     * @param StopReason|value-of<StopReason> $stopReason
     * @param list<int>|null $newDirectReplyPages
     */
    public static function with(
        string $name,
        int $newDirectReplies,
        int $newNestedReplies,
        int $pagesAttempted,
        StopReason|string $stopReason,
        ?array $newDirectReplyPages = null
    ): self {
        $self = new self;

        $self['name'] = $name;
        $self['newDirectReplies'] = $newDirectReplies;
        $self['newNestedReplies'] = $newNestedReplies;
        $self['pagesAttempted'] = $pagesAttempted;
        $self['stopReason'] = $stopReason;

        null !== $newDirectReplyPages && $self['newDirectReplyPages'] = $newDirectReplyPages;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withNewDirectReplies(int $newDirectReplies): self
    {
        $self = clone $this;
        $self['newDirectReplies'] = $newDirectReplies;

        return $self;
    }

    public function withNewNestedReplies(int $newNestedReplies): self
    {
        $self = clone $this;
        $self['newNestedReplies'] = $newNestedReplies;

        return $self;
    }

    public function withPagesAttempted(int $pagesAttempted): self
    {
        $self = clone $this;
        $self['pagesAttempted'] = $pagesAttempted;

        return $self;
    }

    /**
     * @param StopReason|value-of<StopReason> $stopReason
     */
    public function withStopReason(StopReason|string $stopReason): self
    {
        $self = clone $this;
        $self['stopReason'] = $stopReason;

        return $self;
    }

    /**
     * The page, from 1, where each new direct reply appeared.
     *
     * @param list<int>|null $newDirectReplyPages
     */
    public function withNewDirectReplyPages(?array $newDirectReplyPages): self
    {
        $self = clone $this;
        $self['newDirectReplyPages'] = $newDirectReplyPages;

        return $self;
    }
}
