<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\AccountConnectionAttempts\AccountConnectionAttemptGetResponse\XAccountConnectionAttemptFailed;
use XTwitterScraper\X\AccountConnectionAttempts\AccountConnectionAttemptGetResponse\XAccountConnectionAttemptPending;
use XTwitterScraper\X\AccountConnectionAttempts\AccountConnectionAttemptGetResponse\XAccountConnectionAttemptSuccess;
use XTwitterScraper\X\AccountConnectionAttempts\AccountConnectionAttemptGetResponse\XAccountConnectionChallenge;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface AccountConnectionAttemptsRawContract
{
    /**
     * @api
     *
     * @param string $id connection attempt ID returned by `POST /x/accounts`
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XAccountConnectionAttemptPending|XAccountConnectionAttemptSuccess|XAccountConnectionAttemptFailed|XAccountConnectionChallenge,>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
