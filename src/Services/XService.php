<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\XContract;
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
use XTwitterScraper\X\XGetArticleResponse;
use XTwitterScraper\X\XGetHomeTimelineResponse;
use XTwitterScraper\X\XGetNotificationsParams\Type;
use XTwitterScraper\X\XGetNotificationsResponse;

/**
 * X data lookups (subscription required).
 *
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
        $this->tweets = new TweetsService($client);
        $this->users = new UsersService($client);
        $this->followers = new FollowersService($client);
        $this->dm = new DmService($client);
        $this->media = new MediaService($client);
        $this->profile = new ProfileService($client);
        $this->communities = new CommunitiesService($client);
        $this->accounts = new AccountsService($client);
        $this->bookmarks = new BookmarksService($client);
        $this->lists = new ListsService($client);
    }

    /**
     * @api
     *
     * Retrieve the full content of an X Article (long-form post) by tweet ID.
     *
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
     * @param string $cursor Pagination cursor from previous response
     * @param string $seenTweetIDs Comma-separated tweet IDs to exclude from results
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getHomeTimeline(
        ?string $cursor = null,
        ?string $seenTweetIDs = null,
        RequestOptions|array|null $requestOptions = null,
    ): XGetHomeTimelineResponse {
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
     * @param string $cursor Pagination cursor from previous response
     * @param Type|value-of<Type> $type Notification type filter
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
     * Get trending topics
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getTrends(
        RequestOptions|array|null $requestOptions = null
    ): mixed {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->getTrends(requestOptions: $requestOptions);

        return $response->parse();
    }
}
