<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetGetRepliesResponse\Diagnostic;

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
     */
    public static function with(
        string $name,
        int $newDirectReplies,
        int $newNestedReplies,
        int $pagesAttempted,
        StopReason|string $stopReason,
    ): self {
        $self = new self;

        $self['name'] = $name;
        $self['newDirectReplies'] = $newDirectReplies;
        $self['newNestedReplies'] = $newNestedReplies;
        $self['pagesAttempted'] = $pagesAttempted;
        $self['stopReason'] = $stopReason;

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
}
