<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Tweets\TweetGetThreadParams\MediaType;
use XTwitterScraper\X\Tweets\TweetGetThreadParams\Quotes;
use XTwitterScraper\X\Tweets\TweetGetThreadParams\Replies;
use XTwitterScraper\X\Tweets\TweetGetThreadParams\Retweets;

/**
 * Get full conversation thread for a tweet.
 *
 * @see XTwitterScraper\Services\X\TweetsService::getThread()
 *
 * @phpstan-type TweetGetThreadParamsShape = array{
 *   anyWords?: string|null,
 *   blueVerifiedOnly?: bool|null,
 *   cashtags?: string|null,
 *   conversationID?: string|null,
 *   cursor?: string|null,
 *   exactPhrase?: string|null,
 *   excludeWords?: string|null,
 *   fromUser?: string|null,
 *   hashtags?: string|null,
 *   inReplyToTweetID?: string|null,
 *   language?: string|null,
 *   maxFaves?: int|null,
 *   maxQuotes?: int|null,
 *   maxReplies?: int|null,
 *   maxRetweets?: int|null,
 *   mediaType?: null|MediaType|value-of<MediaType>,
 *   mentioning?: string|null,
 *   minBookmarks?: int|null,
 *   minFaves?: int|null,
 *   minQuotes?: int|null,
 *   minReplies?: int|null,
 *   minRetweets?: int|null,
 *   minViews?: int|null,
 *   pageSize?: int|null,
 *   quotes?: null|Quotes|value-of<Quotes>,
 *   quotesOfTweetID?: string|null,
 *   replies?: null|Replies|value-of<Replies>,
 *   retweets?: null|Retweets|value-of<Retweets>,
 *   retweetsOfTweetID?: string|null,
 *   sinceDate?: string|null,
 *   toUser?: string|null,
 *   untilDate?: string|null,
 *   url?: string|null,
 *   verifiedOnly?: bool|null,
 * }
 */
final class TweetGetThreadParams implements BaseModel
{
    /** @use SdkModel<TweetGetThreadParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     */
    #[Optional]
    public ?string $anyWords;

    /**
     * Only return tweets from Blue-verified authors.
     */
    #[Optional]
    public ?bool $blueVerifiedOnly;

    /**
     * Cashtags separated by spaces, commas, or lines.
     */
    #[Optional]
    public ?string $cashtags;

    /**
     * Conversation ID filter.
     */
    #[Optional]
    public ?string $conversationID;

    /**
     * Pagination cursor for thread tweets.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Exact phrase to match.
     */
    #[Optional]
    public ?string $exactPhrase;

    /**
     * Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     */
    #[Optional]
    public ?string $excludeWords;

    /**
     * Filter by author username.
     */
    #[Optional]
    public ?string $fromUser;

    /**
     * Hashtags separated by spaces, commas, or lines.
     */
    #[Optional]
    public ?string $hashtags;

    /**
     * Only replies to this tweet ID.
     */
    #[Optional]
    public ?string $inReplyToTweetID;

    /**
     * Language code filter, e.g. en or tr.
     */
    #[Optional]
    public ?string $language;

    /**
     * Maximum likes threshold. maxLikes is also accepted.
     */
    #[Optional]
    public ?int $maxFaves;

    /**
     * Maximum quotes threshold.
     */
    #[Optional]
    public ?int $maxQuotes;

    /**
     * Maximum replies threshold.
     */
    #[Optional]
    public ?int $maxReplies;

    /**
     * Maximum retweets threshold.
     */
    #[Optional]
    public ?int $maxRetweets;

    /**
     * Filter by media type.
     *
     * @var value-of<MediaType>|null $mediaType
     */
    #[Optional(enum: MediaType::class)]
    public ?string $mediaType;

    /**
     * Filter tweets mentioning a username.
     */
    #[Optional]
    public ?string $mentioning;

    /**
     * Minimum bookmark count threshold.
     */
    #[Optional]
    public ?int $minBookmarks;

    /**
     * Minimum likes threshold. minLikes is also accepted.
     */
    #[Optional]
    public ?int $minFaves;

    /**
     * Minimum quote count threshold.
     */
    #[Optional]
    public ?int $minQuotes;

    /**
     * Minimum replies threshold.
     */
    #[Optional]
    public ?int $minReplies;

    /**
     * Minimum retweets threshold.
     */
    #[Optional]
    public ?int $minRetweets;

    /**
     * Minimum view count threshold.
     */
    #[Optional]
    public ?int $minViews;

    /**
     * Maximum page items (1-100, default 20). Source, filters, or credits can reduce results. Continue while has_next_page is true. Deprecated limit and count aliases remain accepted.
     */
    #[Optional]
    public ?int $pageSize;

    /**
     * Quote mode.
     *
     * @var value-of<Quotes>|null $quotes
     */
    #[Optional(enum: Quotes::class)]
    public ?string $quotes;

    /**
     * Only quotes of this tweet ID.
     */
    #[Optional]
    public ?string $quotesOfTweetID;

    /**
     * Reply mode.
     *
     * @var value-of<Replies>|null $replies
     */
    #[Optional(enum: Replies::class)]
    public ?string $replies;

    /**
     * Retweet mode.
     *
     * @var value-of<Retweets>|null $retweets
     */
    #[Optional(enum: Retweets::class)]
    public ?string $retweets;

    /**
     * Only retweets of this tweet ID.
     */
    #[Optional]
    public ?string $retweetsOfTweetID;

    /**
     * Start date in YYYY-MM-DD format.
     */
    #[Optional]
    public ?string $sinceDate;

    /**
     * Filter replies sent to a username.
     */
    #[Optional]
    public ?string $toUser;

    /**
     * End date in YYYY-MM-DD format.
     */
    #[Optional]
    public ?string $untilDate;

    /**
     * URL substring or domain filter.
     */
    #[Optional]
    public ?string $url;

    /**
     * Only return tweets from verified authors.
     */
    #[Optional]
    public ?bool $verifiedOnly;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param MediaType|value-of<MediaType>|null $mediaType
     * @param Quotes|value-of<Quotes>|null $quotes
     * @param Replies|value-of<Replies>|null $replies
     * @param Retweets|value-of<Retweets>|null $retweets
     */
    public static function with(
        ?string $anyWords = null,
        ?bool $blueVerifiedOnly = null,
        ?string $cashtags = null,
        ?string $conversationID = null,
        ?string $cursor = null,
        ?string $exactPhrase = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $hashtags = null,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        ?int $maxFaves = null,
        ?int $maxQuotes = null,
        ?int $maxReplies = null,
        ?int $maxRetweets = null,
        MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minBookmarks = null,
        ?int $minFaves = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        ?int $minViews = null,
        ?int $pageSize = null,
        Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        Replies|string|null $replies = null,
        Retweets|string|null $retweets = null,
        ?string $retweetsOfTweetID = null,
        ?string $sinceDate = null,
        ?string $toUser = null,
        ?string $untilDate = null,
        ?string $url = null,
        ?bool $verifiedOnly = null,
    ): self {
        $self = new self;

        null !== $anyWords && $self['anyWords'] = $anyWords;
        null !== $blueVerifiedOnly && $self['blueVerifiedOnly'] = $blueVerifiedOnly;
        null !== $cashtags && $self['cashtags'] = $cashtags;
        null !== $conversationID && $self['conversationID'] = $conversationID;
        null !== $cursor && $self['cursor'] = $cursor;
        null !== $exactPhrase && $self['exactPhrase'] = $exactPhrase;
        null !== $excludeWords && $self['excludeWords'] = $excludeWords;
        null !== $fromUser && $self['fromUser'] = $fromUser;
        null !== $hashtags && $self['hashtags'] = $hashtags;
        null !== $inReplyToTweetID && $self['inReplyToTweetID'] = $inReplyToTweetID;
        null !== $language && $self['language'] = $language;
        null !== $maxFaves && $self['maxFaves'] = $maxFaves;
        null !== $maxQuotes && $self['maxQuotes'] = $maxQuotes;
        null !== $maxReplies && $self['maxReplies'] = $maxReplies;
        null !== $maxRetweets && $self['maxRetweets'] = $maxRetweets;
        null !== $mediaType && $self['mediaType'] = $mediaType;
        null !== $mentioning && $self['mentioning'] = $mentioning;
        null !== $minBookmarks && $self['minBookmarks'] = $minBookmarks;
        null !== $minFaves && $self['minFaves'] = $minFaves;
        null !== $minQuotes && $self['minQuotes'] = $minQuotes;
        null !== $minReplies && $self['minReplies'] = $minReplies;
        null !== $minRetweets && $self['minRetweets'] = $minRetweets;
        null !== $minViews && $self['minViews'] = $minViews;
        null !== $pageSize && $self['pageSize'] = $pageSize;
        null !== $quotes && $self['quotes'] = $quotes;
        null !== $quotesOfTweetID && $self['quotesOfTweetID'] = $quotesOfTweetID;
        null !== $replies && $self['replies'] = $replies;
        null !== $retweets && $self['retweets'] = $retweets;
        null !== $retweetsOfTweetID && $self['retweetsOfTweetID'] = $retweetsOfTweetID;
        null !== $sinceDate && $self['sinceDate'] = $sinceDate;
        null !== $toUser && $self['toUser'] = $toUser;
        null !== $untilDate && $self['untilDate'] = $untilDate;
        null !== $url && $self['url'] = $url;
        null !== $verifiedOnly && $self['verifiedOnly'] = $verifiedOnly;

        return $self;
    }

    /**
     * Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     */
    public function withAnyWords(string $anyWords): self
    {
        $self = clone $this;
        $self['anyWords'] = $anyWords;

        return $self;
    }

    /**
     * Only return tweets from Blue-verified authors.
     */
    public function withBlueVerifiedOnly(bool $blueVerifiedOnly): self
    {
        $self = clone $this;
        $self['blueVerifiedOnly'] = $blueVerifiedOnly;

        return $self;
    }

    /**
     * Cashtags separated by spaces, commas, or lines.
     */
    public function withCashtags(string $cashtags): self
    {
        $self = clone $this;
        $self['cashtags'] = $cashtags;

        return $self;
    }

    /**
     * Conversation ID filter.
     */
    public function withConversationID(string $conversationID): self
    {
        $self = clone $this;
        $self['conversationID'] = $conversationID;

        return $self;
    }

    /**
     * Pagination cursor for thread tweets.
     */
    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Exact phrase to match.
     */
    public function withExactPhrase(string $exactPhrase): self
    {
        $self = clone $this;
        $self['exactPhrase'] = $exactPhrase;

        return $self;
    }

    /**
     * Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     */
    public function withExcludeWords(string $excludeWords): self
    {
        $self = clone $this;
        $self['excludeWords'] = $excludeWords;

        return $self;
    }

    /**
     * Filter by author username.
     */
    public function withFromUser(string $fromUser): self
    {
        $self = clone $this;
        $self['fromUser'] = $fromUser;

        return $self;
    }

    /**
     * Hashtags separated by spaces, commas, or lines.
     */
    public function withHashtags(string $hashtags): self
    {
        $self = clone $this;
        $self['hashtags'] = $hashtags;

        return $self;
    }

    /**
     * Only replies to this tweet ID.
     */
    public function withInReplyToTweetID(string $inReplyToTweetID): self
    {
        $self = clone $this;
        $self['inReplyToTweetID'] = $inReplyToTweetID;

        return $self;
    }

    /**
     * Language code filter, e.g. en or tr.
     */
    public function withLanguage(string $language): self
    {
        $self = clone $this;
        $self['language'] = $language;

        return $self;
    }

    /**
     * Maximum likes threshold. maxLikes is also accepted.
     */
    public function withMaxFaves(int $maxFaves): self
    {
        $self = clone $this;
        $self['maxFaves'] = $maxFaves;

        return $self;
    }

    /**
     * Maximum quotes threshold.
     */
    public function withMaxQuotes(int $maxQuotes): self
    {
        $self = clone $this;
        $self['maxQuotes'] = $maxQuotes;

        return $self;
    }

    /**
     * Maximum replies threshold.
     */
    public function withMaxReplies(int $maxReplies): self
    {
        $self = clone $this;
        $self['maxReplies'] = $maxReplies;

        return $self;
    }

    /**
     * Maximum retweets threshold.
     */
    public function withMaxRetweets(int $maxRetweets): self
    {
        $self = clone $this;
        $self['maxRetweets'] = $maxRetweets;

        return $self;
    }

    /**
     * Filter by media type.
     *
     * @param MediaType|value-of<MediaType> $mediaType
     */
    public function withMediaType(MediaType|string $mediaType): self
    {
        $self = clone $this;
        $self['mediaType'] = $mediaType;

        return $self;
    }

    /**
     * Filter tweets mentioning a username.
     */
    public function withMentioning(string $mentioning): self
    {
        $self = clone $this;
        $self['mentioning'] = $mentioning;

        return $self;
    }

    /**
     * Minimum bookmark count threshold.
     */
    public function withMinBookmarks(int $minBookmarks): self
    {
        $self = clone $this;
        $self['minBookmarks'] = $minBookmarks;

        return $self;
    }

    /**
     * Minimum likes threshold. minLikes is also accepted.
     */
    public function withMinFaves(int $minFaves): self
    {
        $self = clone $this;
        $self['minFaves'] = $minFaves;

        return $self;
    }

    /**
     * Minimum quote count threshold.
     */
    public function withMinQuotes(int $minQuotes): self
    {
        $self = clone $this;
        $self['minQuotes'] = $minQuotes;

        return $self;
    }

    /**
     * Minimum replies threshold.
     */
    public function withMinReplies(int $minReplies): self
    {
        $self = clone $this;
        $self['minReplies'] = $minReplies;

        return $self;
    }

    /**
     * Minimum retweets threshold.
     */
    public function withMinRetweets(int $minRetweets): self
    {
        $self = clone $this;
        $self['minRetweets'] = $minRetweets;

        return $self;
    }

    /**
     * Minimum view count threshold.
     */
    public function withMinViews(int $minViews): self
    {
        $self = clone $this;
        $self['minViews'] = $minViews;

        return $self;
    }

    /**
     * Maximum page items (1-100, default 20). Source, filters, or credits can reduce results. Continue while has_next_page is true. Deprecated limit and count aliases remain accepted.
     */
    public function withPageSize(int $pageSize): self
    {
        $self = clone $this;
        $self['pageSize'] = $pageSize;

        return $self;
    }

    /**
     * Quote mode.
     *
     * @param Quotes|value-of<Quotes> $quotes
     */
    public function withQuotes(Quotes|string $quotes): self
    {
        $self = clone $this;
        $self['quotes'] = $quotes;

        return $self;
    }

    /**
     * Only quotes of this tweet ID.
     */
    public function withQuotesOfTweetID(string $quotesOfTweetID): self
    {
        $self = clone $this;
        $self['quotesOfTweetID'] = $quotesOfTweetID;

        return $self;
    }

    /**
     * Reply mode.
     *
     * @param Replies|value-of<Replies> $replies
     */
    public function withReplies(Replies|string $replies): self
    {
        $self = clone $this;
        $self['replies'] = $replies;

        return $self;
    }

    /**
     * Retweet mode.
     *
     * @param Retweets|value-of<Retweets> $retweets
     */
    public function withRetweets(Retweets|string $retweets): self
    {
        $self = clone $this;
        $self['retweets'] = $retweets;

        return $self;
    }

    /**
     * Only retweets of this tweet ID.
     */
    public function withRetweetsOfTweetID(string $retweetsOfTweetID): self
    {
        $self = clone $this;
        $self['retweetsOfTweetID'] = $retweetsOfTweetID;

        return $self;
    }

    /**
     * Start date in YYYY-MM-DD format.
     */
    public function withSinceDate(string $sinceDate): self
    {
        $self = clone $this;
        $self['sinceDate'] = $sinceDate;

        return $self;
    }

    /**
     * Filter replies sent to a username.
     */
    public function withToUser(string $toUser): self
    {
        $self = clone $this;
        $self['toUser'] = $toUser;

        return $self;
    }

    /**
     * End date in YYYY-MM-DD format.
     */
    public function withUntilDate(string $untilDate): self
    {
        $self = clone $this;
        $self['untilDate'] = $untilDate;

        return $self;
    }

    /**
     * URL substring or domain filter.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Only return tweets from verified authors.
     */
    public function withVerifiedOnly(bool $verifiedOnly): self
    {
        $self = clone $this;
        $self['verifiedOnly'] = $verifiedOnly;

        return $self;
    }
}
