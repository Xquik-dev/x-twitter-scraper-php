<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Create tweet.
 *
 * @see XTwitterScraper\Services\X\TweetsService::create()
 *
 * @phpstan-type TweetCreateParamsShape = array{
 *   account: string,
 *   idempotencyKey: string,
 *   communityID?: string|null,
 *   isNoteTweet?: bool|null,
 *   media?: list<string>|null,
 *   replyToTweetID?: string|null,
 *   text?: string|null,
 * }
 */
final class TweetCreateParams implements BaseModel
{
    /** @use SdkModel<TweetCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * X account (@username or account ID).
     */
    #[Required]
    public string $account;

    #[Required]
    public string $idempotencyKey;

    #[Optional('community_id')]
    public ?string $communityID;

    #[Optional('is_note_tweet')]
    public ?bool $isNoteTweet;

    /**
     * Array of public media URLs to attach. Supports up to 4 images or exactly 1 MP4 video up to 100 MB. Each URL must be publicly reachable. Attached media adds 2 credits per started MB across all files.
     *
     * @var list<string>|null $media
     */
    #[Optional(list: 'string')]
    public ?array $media;

    #[Optional('reply_to_tweet_id')]
    public ?string $replyToTweetID;

    /**
     * Tweet text (optional when media is provided).
     */
    #[Optional]
    public ?string $text;

    /**
     * `new TweetCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetCreateParams::with(account: ..., idempotencyKey: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetCreateParams)->withAccount(...)->withIdempotencyKey(...)
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
     * @param list<string>|null $media
     */
    public static function with(
        string $account,
        string $idempotencyKey,
        ?string $communityID = null,
        ?bool $isNoteTweet = null,
        ?array $media = null,
        ?string $replyToTweetID = null,
        ?string $text = null,
    ): self {
        $self = new self;

        $self['account'] = $account;
        $self['idempotencyKey'] = $idempotencyKey;

        null !== $communityID && $self['communityID'] = $communityID;
        null !== $isNoteTweet && $self['isNoteTweet'] = $isNoteTweet;
        null !== $media && $self['media'] = $media;
        null !== $replyToTweetID && $self['replyToTweetID'] = $replyToTweetID;
        null !== $text && $self['text'] = $text;

        return $self;
    }

    /**
     * X account (@username or account ID).
     */
    public function withAccount(string $account): self
    {
        $self = clone $this;
        $self['account'] = $account;

        return $self;
    }

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    public function withCommunityID(string $communityID): self
    {
        $self = clone $this;
        $self['communityID'] = $communityID;

        return $self;
    }

    public function withIsNoteTweet(bool $isNoteTweet): self
    {
        $self = clone $this;
        $self['isNoteTweet'] = $isNoteTweet;

        return $self;
    }

    /**
     * Array of public media URLs to attach. Supports up to 4 images or exactly 1 MP4 video up to 100 MB. Each URL must be publicly reachable. Attached media adds 2 credits per started MB across all files.
     *
     * @param list<string> $media
     */
    public function withMedia(array $media): self
    {
        $self = clone $this;
        $self['media'] = $media;

        return $self;
    }

    public function withReplyToTweetID(string $replyToTweetID): self
    {
        $self = clone $this;
        $self['replyToTweetID'] = $replyToTweetID;

        return $self;
    }

    /**
     * Tweet text (optional when media is provided).
     */
    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }
}
