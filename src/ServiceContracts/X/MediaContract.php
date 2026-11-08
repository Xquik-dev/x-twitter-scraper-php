<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Media\MediaDownloadResponse;
use XTwitterScraper\X\Media\MediaUploadResponse;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
interface MediaContract
{
    /**
     * @api
     *
     * @param string $imageShows Save only posts whose photos show this. Send charts, screenshots, product_photos, memes or people, or describe it in words, such as a rocket. AI-powered analysis checks posts with photos X doesn't mark sensitive & keeps scores of 0.5 or more. Each post saved costs 2 credits, the AI analysis price, on top of its save price, & a post the filter drops costs nothing. imageFilter states the cutoff & counts.
     * @param string $tweetID Numeric tweet ID alias for tweetInput
     * @param list<string> $tweetIDs Array of tweet URLs or IDs (bulk, max 50 string items)
     * @param string $tweetInput Tweet URL or ID (single tweet)
     * @param string $tweetURL Tweet URL alias for tweetInput
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function download(
        ?string $imageShows = null,
        ?string $tweetID = null,
        ?array $tweetIDs = null,
        ?string $tweetInput = null,
        ?string $tweetURL = null,
        RequestOptions|array|null $requestOptions = null,
    ): MediaDownloadResponse;

    /**
     * @api
     *
     * @param string $account Body param: X account (@username or ID) uploading media from URL
     * @param string $url Body param: HTTPS URL to download and upload as media
     * @param string $idempotencyKey Header param: Generate one unique value for each intended write. Reuse it only when retrying the exact same account, action, target, and payload. A reused key returns the original action. Reusing it with different input returns 409. Replay protection remains active for at least 90 days.
     * @param string|null $file Media file to upload, up to 95 MB. A larger file gets 413 `media_too_large` before any account lookup.
     * @param bool|null $isLongVideo set true only for video/mp4 multipart uploads longer than 140 seconds
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function upload(
        string $account,
        string $url,
        string $idempotencyKey,
        ?string $file = null,
        ?bool $isLongVideo = null,
        RequestOptions|array|null $requestOptions = null,
    ): MediaUploadResponse;
}
