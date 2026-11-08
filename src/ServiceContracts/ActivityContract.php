<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Activity\ActivityListParams\Format;
use XTwitterScraper\ActivityLogRow;
use XTwitterScraper\ActivityRecord;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
interface ActivityContract
{
    /**
     * @api
     *
     * @param Format|value-of<Format>|null $format Answer format. JSON by default.
     * @param int|null $limit Most rows to return, with no upper limit. A PDF above 10,000 rows comes as a ZIP of PDF parts.
     * @param string|null $category Activity group, like the Activity page's tabs. `all` by default, or `actions`, `extractions`, `monitors`, `webhooks` or `billing`.
     * @param string|null $status comma-separated statuses
     * @param string|null $q search text
     * @param \DateTimeInterface|null $since oldest time, ISO 8601
     * @param \DateTimeInterface|null $until newest time, ISO 8601
     * @param RequestOpts|null $requestOptions
     *
     * @return list<ActivityLogRow>
     *
     * @throws APIException
     */
    public function list(
        Format|string|null $format = null,
        ?int $limit = null,
        ?string $category = null,
        ?string $status = null,
        ?string $q = null,
        ?\DateTimeInterface $since = null,
        ?\DateTimeInterface $until = null,
        RequestOptions|array|null $requestOptions = null,
    ): array;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null,
    ): ActivityRecord;
}
