<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\FootballBoxScore;
use XTwitterScraper\FootballPlays;
use XTwitterScraper\FootballProps;
use XTwitterScraper\FootballRoster;
use XTwitterScraper\FootballSchedule;
use XTwitterScraper\FootballScoreboard;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\SportsRawContract;
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
 * Sport operations of the Xquik API.
 *
 * @phpstan-import-type RequestOpts from RequestOptions
 */
final class SportsRawService implements SportsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Lists NFL or college football games in a time window, with teams & scores. Use it to find game IDs & team IDs. Without from or to, X picks about 5 weeks around today. Each request costs 1 credit.
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
    ): BaseResponse {
        [$parsed, $options] = SportListGamesParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/sports/%1$s/games', $league],
            query: $parsed,
            options: $options,
            convert: FootballSchedule::class,
        );
    }

    /**
     * @api
     *
     * Returns 1 game's scoreboard. It has the teams, the score by period, the status & clock, down & distance, the venue & the latest play. Each request costs 1 credit.
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
    ): BaseResponse {
        [$parsed, $options] = SportRetrieveScoreboardParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/sports/%1$s/games/%2$s', $league, $id],
            query: $parsed,
            options: $options,
            convert: FootballScoreboard::class,
        );
    }

    /**
     * @api
     *
     * Returns who follows 1 game on X. It has live viewers, fan picks per team & the game chat's state. Each request costs 1 credit.
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
    ): BaseResponse {
        [$parsed, $options] = SportRetrieveAudienceParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/sports/%1$s/games/%2$s/audience', $league, $id],
            query: $parsed,
            options: $options,
            convert: SportsGameAudience::class,
        );
    }

    /**
     * @api
     *
     * Returns each team's totals & each player's stats for 1 game. Stats cover passing, rushing, receiving, defense, kicking & returns. A game that has not started has no stats yet. Each request costs 1 credit.
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
    ): BaseResponse {
        [$parsed, $options] = SportRetrieveBoxScoreParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/sports/%1$s/games/%2$s/box-score', $league, $id],
            query: $parsed,
            options: $options,
            convert: FootballBoxScore::class,
        );
    }

    /**
     * @api
     *
     * Returns every drive & play of 1 game, by quarter. Each play has its clock, down & distance, details, penalties & linked posts. Each request costs 1 credit.
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
    ): BaseResponse {
        [$parsed, $options] = SportRetrievePlaysParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/sports/%1$s/games/%2$s/plays', $league, $id],
            query: $parsed,
            options: $options,
            convert: FootballPlays::class,
        );
    }

    /**
     * @api
     *
     * Returns both teams' players for 1 NFL game. Each player has a jersey, position, headshot & X account. Each request costs 1 credit.
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
    ): BaseResponse {
        [$parsed, $options] = SportRetrieveRosterParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/sports/%1$s/games/%2$s/roster', $league, $id],
            query: $parsed,
            options: $options,
            convert: FootballRoster::class,
        );
    }

    /**
     * @api
     *
     * Returns the player prop lines & American odds X shows for 1 NFL game. X lists props before & during a game. Other games return no categories. Each request costs 1 credit.
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
    ): BaseResponse {
        [$parsed, $options] = SportRetrievePlayerPropsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/sports/%1$s/games/%2$s/player-props', $league, $id],
            query: $parsed,
            options: $options,
            convert: FootballProps::class,
        );
    }

    /**
     * @api
     *
     * Returns a game's top or latest posts, plus an X search you can run for more. Works before, during & after the game. Pages hold up to 20 posts, & each post costs 1 credit.
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
    ): BaseResponse {
        [$parsed, $options] = SportListPostsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/sports/%1$s/games/%2$s/posts', $league, $id],
            query: $parsed,
            options: $options,
            convert: SportsGamePosts::class,
        );
    }
}
