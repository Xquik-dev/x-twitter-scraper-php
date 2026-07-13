<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type TweetNewResponseShape = array{
 *   charged: bool,
 *   chargedCredits: string,
 *   success: bool,
 *   tweetID: string,
 *   writeActionID?: string|null,
 * }
 */
final class TweetNewResponse implements BaseModel
{
    /** @use SdkModel<TweetNewResponseShape> */
    use SdkModel;

    #[Required]
    public bool $success = true;

    #[Required]
    public bool $charged;

    /**
     * Credits charged for this tweet. Text-only tweets and replies cost 30 credits; attached media adds 2 credits per started MB.
     */
    #[Required]
    public string $chargedCredits;

    #[Required('tweetId')]
    public string $tweetID;

    #[Optional('writeActionId')]
    public ?string $writeActionID;

    /**
     * `new TweetNewResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetNewResponse::with(charged: ..., chargedCredits: ..., tweetID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetNewResponse)
     *   ->withCharged(...)
     *   ->withChargedCredits(...)
     *   ->withTweetID(...)
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
        bool $charged,
        string $chargedCredits,
        string $tweetID,
        ?string $writeActionID = null,
    ): self {
        $self = new self;

        $self['charged'] = $charged;
        $self['chargedCredits'] = $chargedCredits;
        $self['tweetID'] = $tweetID;

        null !== $writeActionID && $self['writeActionID'] = $writeActionID;

        return $self;
    }

    public function withCharged(bool $charged): self
    {
        $self = clone $this;
        $self['charged'] = $charged;

        return $self;
    }

    /**
     * Credits charged for this tweet. Text-only tweets and replies cost 30 credits; attached media adds 2 credits per started MB.
     */
    public function withChargedCredits(string $chargedCredits): self
    {
        $self = clone $this;
        $self['chargedCredits'] = $chargedCredits;

        return $self;
    }

    public function withSuccess(bool $success): self
    {
        $self = clone $this;
        $self['success'] = $success;

        return $self;
    }

    public function withTweetID(string $tweetID): self
    {
        $self = clone $this;
        $self['tweetID'] = $tweetID;

        return $self;
    }

    public function withWriteActionID(string $writeActionID): self
    {
        $self = clone $this;
        $self['writeActionID'] = $writeActionID;

        return $self;
    }
}
