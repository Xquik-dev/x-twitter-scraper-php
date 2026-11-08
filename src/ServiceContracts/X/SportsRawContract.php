<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\FootballBoxScore;
use XTwitterScraper\FootballPlays;
use XTwitterScraper\FootballProps;
use XTwitterScraper\FootballRoster;
use XTwitterScraper\FootballSchedule;
use XTwitterScraper\FootballScoreboard;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\SportsGameAudience;
use XTwitterScraper\SportsGamePosts;
use XTwitterScraper\X\Sports\SportListGamesParams;
use XTwitterScraper\X\Sports\SportListPostsParams;
use XTwitterScraper\X\Sports\SportRetrieveAudienceParams;
use XTwitterScraper\X\Sports\SportRetrieveBoxScoreParams;
use XTwitterScraper\X\Sports\SportRetrievePlayerPropsParams;
use XTwitterScraper\X\Sports\SportRetrievePlaysParams;
use XTwitterScraper\X\Sports\SportRetrieveRosterParams;
use XTwitterScraper\X\Sports\SportRetrieveScoreboardParams;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
interface SportsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|SportListGamesParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FootballSchedule>
     *
     * @throws APIException
     */
    public function listGames(
        string $league,
        array|SportListGamesParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|SportRetrieveScoreboardParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FootballScoreboard>
     *
     * @throws APIException
     */
    public function retrieveScoreboard(
        string $league,
        string $id,
        array|SportRetrieveScoreboardParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|SportRetrieveAudienceParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SportsGameAudience>
     *
     * @throws APIException
     */
    public function retrieveAudience(
        string $league,
        string $id,
        array|SportRetrieveAudienceParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|SportRetrieveBoxScoreParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FootballBoxScore>
     *
     * @throws APIException
     */
    public function retrieveBoxScore(
        string $league,
        string $id,
        array|SportRetrieveBoxScoreParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|SportRetrievePlaysParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FootballPlays>
     *
     * @throws APIException
     */
    public function retrievePlays(
        string $league,
        string $id,
        array|SportRetrievePlaysParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|SportRetrieveRosterParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FootballRoster>
     *
     * @throws APIException
     */
    public function retrieveRoster(
        string $league,
        string $id,
        array|SportRetrieveRosterParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|SportRetrievePlayerPropsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FootballProps>
     *
     * @throws APIException
     */
    public function retrievePlayerProps(
        string $league,
        string $id,
        array|SportRetrievePlayerPropsParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|SportListPostsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SportsGamePosts>
     *
     * @throws APIException
     */
    public function listPosts(
        string $league,
        string $id,
        array|SportListPostsParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
