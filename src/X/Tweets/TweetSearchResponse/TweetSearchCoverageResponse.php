<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetSearchResponse;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\SearchTweet;
use XTwitterScraper\X\Tweets\TweetSearchResponse\TweetSearchCoverageResponse\Diagnostic;

/**
 * No-mode search, user Tweet, user reply, and direct reply reads use automatic coverage. Shape, filters, aliases, and billing stay compatible. Unprefixed cursors remain legacy. Follow next_cursor while has_next_page is true. An empty filtered page can still have has_next_page true.
 *
 * @phpstan-import-type DiagnosticShape from \XTwitterScraper\X\Tweets\TweetSearchResponse\TweetSearchCoverageResponse\Diagnostic
 *
 * @phpstan-type TweetSearchCoverageResponseShape = array{
 *   hasNextPage: bool,
 *   nextCursor: string,
 *   tweets: list<mixed>,
 *   diagnostic: Diagnostic|DiagnosticShape,
 * }
 */
final class TweetSearchCoverageResponse implements BaseModel
{
    /** @use SdkModel<TweetSearchCoverageResponseShape> */
    use SdkModel;

    #[Required('has_next_page')]
    public bool $hasNextPage;

    #[Required('next_cursor')]
    public string $nextCursor;

    /** @var list<mixed> $tweets */
    #[Required(list: SearchTweet::class)]
    public array $tweets;

    /**
     * Coverage evidence across parallel search strategies.
     */
    #[Required]
    public Diagnostic $diagnostic;

    /**
     * `new TweetSearchCoverageResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetSearchCoverageResponse::with(
     *   hasNextPage: ..., nextCursor: ..., tweets: ..., diagnostic: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetSearchCoverageResponse)
     *   ->withHasNextPage(...)
     *   ->withNextCursor(...)
     *   ->withTweets(...)
     *   ->withDiagnostic(...)
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
     * @param list<mixed> $tweets
     * @param Diagnostic|DiagnosticShape $diagnostic
     */
    public static function with(
        bool $hasNextPage,
        string $nextCursor,
        array $tweets,
        Diagnostic|array $diagnostic,
    ): self {
        $self = new self;

        $self['hasNextPage'] = $hasNextPage;
        $self['nextCursor'] = $nextCursor;
        $self['tweets'] = $tweets;
        $self['diagnostic'] = $diagnostic;

        return $self;
    }

    public function withHasNextPage(bool $hasNextPage): self
    {
        $self = clone $this;
        $self['hasNextPage'] = $hasNextPage;

        return $self;
    }

    public function withNextCursor(string $nextCursor): self
    {
        $self = clone $this;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }

    /**
     * @param list<mixed> $tweets
     */
    public function withTweets(array $tweets): self
    {
        $self = clone $this;
        $self['tweets'] = $tweets;

        return $self;
    }

    /**
     * Coverage evidence across parallel search strategies.
     *
     * @param Diagnostic|DiagnosticShape $diagnostic
     */
    public function withDiagnostic(Diagnostic|array $diagnostic): self
    {
        $self = clone $this;
        $self['diagnostic'] = $diagnostic;

        return $self;
    }
}
