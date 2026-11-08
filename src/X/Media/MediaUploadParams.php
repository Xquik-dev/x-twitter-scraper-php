<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Media;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Upload media.
 *
 * @see XTwitterScraper\Services\X\MediaService::upload()
 *
 * @phpstan-type MediaUploadParamsShape = array{
 *   account: string, url: string, idempotencyKey: string,
 *   file?: string|null,
 *   isLongVideo?: bool|null,
 * }
 */
final class MediaUploadParams implements BaseModel
{
    /** @use SdkModel<MediaUploadParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * X account (@username or ID) uploading media from URL.
     */
    #[Required]
    public string $account;

    /**
     * HTTPS URL to download and upload as media.
     */
    #[Required]
    public string $url;

    #[Required]
    public string $idempotencyKey;

    /**
     * Media file to upload, up to 95 MB. A larger file gets 413 `media_too_large` before any account lookup.
     */
    #[Optional]
    public ?string $file;

    /**
     * Set true only for video/mp4 multipart uploads longer than 140 seconds.
     */
    #[Optional('is_long_video')]
    public ?bool $isLongVideo;

    /**
     * `new MediaUploadParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MediaUploadParams::with(account: ..., url: ..., idempotencyKey: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MediaUploadParams)->withAccount(...)->withURL(...)->withIdempotencyKey(...)
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
     */
    public static function with(
        string $account,
        string $url,
        string $idempotencyKey,
        ?string $file = null,
        ?bool $isLongVideo = null
    ): self {
        $self = new self;

        $self['account'] = $account;
        $self['url'] = $url;
        $self['idempotencyKey'] = $idempotencyKey;

        null !== $file && $self['file'] = $file;

        null !== $isLongVideo && $self['isLongVideo'] = $isLongVideo;

        return $self;
    }

    /**
     * X account (@username or ID) uploading media from URL.
     */
    public function withAccount(string $account): self
    {
        $self = clone $this;
        $self['account'] = $account;

        return $self;
    }

    /**
     * HTTPS URL to download and upload as media.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    /**
     * Media file to upload, up to 95 MB. A larger file gets 413 `media_too_large` before any account lookup.
     */
    public function withFile(?string $file): self
    {
        $self = clone $this;
        $self['file'] = $file;

        return $self;
    }

    /**
     * Set true only for video/mp4 multipart uploads longer than 140 seconds.
     */
    public function withIsLongVideo(?bool $isLongVideo): self
    {
        $self = clone $this;
        $self['isLongVideo'] = $isLongVideo;

        return $self;
    }
}
