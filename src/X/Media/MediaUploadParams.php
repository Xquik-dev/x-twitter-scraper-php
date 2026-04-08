<?php

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
 *   account: string, file: string, isLongVideo?: bool|null
 * }
 */
final class MediaUploadParams implements BaseModel
{
    /** @use SdkModel<MediaUploadParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * X account (@username or ID) uploading media.
     */
    #[Required]
    public string $account;

    /**
     * Media file to upload.
     */
    #[Required]
    public string $file;

    #[Optional('is_long_video')]
    public ?bool $isLongVideo;

    /**
     * `new MediaUploadParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MediaUploadParams::with(account: ..., file: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MediaUploadParams)->withAccount(...)->withFile(...)
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
        string $file,
        ?bool $isLongVideo = null
    ): self {
        $self = new self;

        $self['account'] = $account;
        $self['file'] = $file;

        null !== $isLongVideo && $self['isLongVideo'] = $isLongVideo;

        return $self;
    }

    /**
     * X account (@username or ID) uploading media.
     */
    public function withAccount(string $account): self
    {
        $self = clone $this;
        $self['account'] = $account;

        return $self;
    }

    /**
     * Media file to upload.
     */
    public function withFile(string $file): self
    {
        $self = clone $this;
        $self['file'] = $file;

        return $self;
    }

    public function withIsLongVideo(bool $isLongVideo): self
    {
        $self = clone $this;
        $self['isLongVideo'] = $isLongVideo;

        return $self;
    }
}
