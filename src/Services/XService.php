<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\XContract;
use XTwitterScraper\Services\X\AccountConnectionChallengesService;
use XTwitterScraper\Services\X\AccountsService;
use XTwitterScraper\Services\X\BookmarksService;
use XTwitterScraper\Services\X\CommunitiesService;
use XTwitterScraper\Services\X\DmService;
use XTwitterScraper\Services\X\FollowersService;
use XTwitterScraper\Services\X\ListsService;
use XTwitterScraper\Services\X\MediaService;
use XTwitterScraper\Services\X\ProfileService;
use XTwitterScraper\Services\X\TweetsService;
use XTwitterScraper\Services\X\UsersService;
use XTwitterScraper\Services\X\WriteActionsService;
use XTwitterScraper\X\XGetArticleResponse;
use XTwitterScraper\X\XGetNotificationsParams\Type;
use XTwitterScraper\X\XGetNotificationsResponse;
use XTwitterScraper\X\XGetTrendsResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class XService implements XContract
{
    /**
     * @api
     */
    public XRawService $raw;

    /**
     * @api
     */
    public WriteActionsService $writeActions;

    /**
     * @api
     */
    public TweetsService $tweets;

    /**
     * @api
     */
    public UsersService $users;

    /**
     * @api
     */
    public FollowersService $followers;

    /**
     * @api
     */
    public DmService $dm;

    /**
     * @api
     */
    public MediaService $media;

    /**
     * @api
     */
    public ProfileService $profile;

    /**
     * @api
     */
    public CommunitiesService $communities;

    /**
     * @api
     */
    public AccountsService $accounts;

    /**
     * @api
     */
    public AccountConnectionChallengesService $accountConnectionChallenges;

    /**
     * @api
     */
    public BookmarksService $bookmarks;

    /**
     * @api
     */
    public ListsService $lists;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new XRawService($client);
        $this->writeActions = new WriteActionsService($client);
        $this->tweets = new TweetsService($client);
        $this->users = new UsersService($client);
        $this->followers = new FollowersService($client);
        $this->dm = new DmService($client);
        $this->media = new MediaService($client);
        $this->profile = new ProfileService($client);
        $this->communities = new CommunitiesService($client);
        $this->accounts = new AccountsService($client);
        $this->accountConnectionChallenges = new AccountConnectionChallengesService($client);
        $this->bookmarks = new BookmarksService($client);
        $this->lists = new ListsService($client);
    }

    /**
     * @api
     *
     * Retrieve the full content of an X Article (long-form post) by numeric tweet ID. Returns article_not_found when the tweet is valid but is not an X Article.
     *
     * @param string $tweetID Numeric tweet ID of the article, 15-20 digits. If you have a tweet URL, use the final status ID.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getArticle(
        string $tweetID,
        RequestOptions|array|null $requestOptions = null
    ): XGetArticleResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->getArticle($tweetID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get home timeline
     *
     * @param string $cursor Pagination cursor for timeline
     * @param string $seenTweetIDs Comma-separated tweet IDs to exclude from results. Empty entries are ignored.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getHomeTimeline(
        ?string $cursor = null,
        ?string $seenTweetIDs = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets {
        $params = Util::removeNulls(
            ['cursor' => $cursor, 'seenTweetIDs' => $seenTweetIDs]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->getHomeTimeline(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get notifications
     *
     * @param string $cursor Pagination cursor for notifications
     * @param Type|value-of<Type> $type Notification type filter. Unrecognized values fall back to All.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getNotifications(
        ?string $cursor = null,
        Type|string $type = 'All',
        RequestOptions|array|null $requestOptions = null,
    ): XGetNotificationsResponse {
        $params = Util::removeNulls(['cursor' => $cursor, 'type' => $type]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->getNotifications(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get trending hashtags and topics from X by region
     *
     * @param int $count Number of trending topics to return (1-50, default 30)
     * @param int $woeid Region WOEID (1=Worldwide, 23424977=US, 23424975=UK, 23424969=Turkey)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getTrends(
        int $count = 30,
        int $woeid = 1,
        RequestOptions|array|null $requestOptions = null,
    ): XGetTrendsResponse {
        $params = Util::removeNulls(['count' => $count, 'woeid' => $woeid]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->getTrends(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
