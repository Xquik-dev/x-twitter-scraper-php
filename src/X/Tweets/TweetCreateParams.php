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
 *   text: string,
 *   attachmentURL?: string|null,
 *   communityID?: string|null,
 *   isNoteTweet?: bool|null,
 *   mediaIDs?: list<string>|null,
 *   replyToTweetID?: string|null,
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
    public string $text;

    #[Optional('attachment_url')]
    public ?string $attachmentURL;

    #[Optional('community_id')]
    public ?string $communityID;

    #[Optional('is_note_tweet')]
    public ?bool $isNoteTweet;

    /** @var list<string>|null $mediaIDs */
    #[Optional('media_ids', list: 'string')]
    public ?array $mediaIDs;

    #[Optional('reply_to_tweet_id')]
    public ?string $replyToTweetID;

    /**
     * `new TweetCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetCreateParams::with(account: ..., text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetCreateParams)->withAccount(...)->withText(...)
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
     * @param list<string>|null $mediaIDs
     */
    public static function with(
        string $account,
        string $text,
        ?string $attachmentURL = null,
        ?string $communityID = null,
        ?bool $isNoteTweet = null,
        ?array $mediaIDs = null,
        ?string $replyToTweetID = null,
    ): self {
        $self = new self;

        $self['account'] = $account;
        $self['text'] = $text;

        null !== $attachmentURL && $self['attachmentURL'] = $attachmentURL;
        null !== $communityID && $self['communityID'] = $communityID;
        null !== $isNoteTweet && $self['isNoteTweet'] = $isNoteTweet;
        null !== $mediaIDs && $self['mediaIDs'] = $mediaIDs;
        null !== $replyToTweetID && $self['replyToTweetID'] = $replyToTweetID;

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

    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    public function withAttachmentURL(string $attachmentURL): self
    {
        $self = clone $this;
        $self['attachmentURL'] = $attachmentURL;

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
     * @param list<string> $mediaIDs
     */
    public function withMediaIDs(array $mediaIDs): self
    {
        $self = clone $this;
        $self['mediaIDs'] = $mediaIDs;

        return $self;
    }

    public function withReplyToTweetID(string $replyToTweetID): self
    {
        $self = clone $this;
        $self['replyToTweetID'] = $replyToTweetID;

        return $self;
    }
}
