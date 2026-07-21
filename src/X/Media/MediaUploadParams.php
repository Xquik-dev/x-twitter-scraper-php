<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Media;

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
 *   account: string, url: string, idempotencyKey: string
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
        string $idempotencyKey
    ): self {
        $self = new self;

        $self['account'] = $account;
        $self['url'] = $url;
        $self['idempotencyKey'] = $idempotencyKey;

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
}
