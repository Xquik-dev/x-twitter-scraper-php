<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Media;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type MediaUploadResponseShape = array{
 *   mediaID: string, mediaURL: string, success: bool
 * }
 */
final class MediaUploadResponse implements BaseModel
{
    /** @use SdkModel<MediaUploadResponseShape> */
    use SdkModel;

    #[Required]
    public bool $success = true;

    #[Required('mediaId')]
    public string $mediaID;

    /**
     * Public media URL for tweet `media` arrays.
     */
    #[Required('mediaUrl')]
    public string $mediaURL;

    /**
     * `new MediaUploadResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MediaUploadResponse::with(mediaID: ..., mediaURL: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MediaUploadResponse)->withMediaID(...)->withMediaURL(...)
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
    public static function with(string $mediaID, string $mediaURL): self
    {
        $self = new self;

        $self['mediaID'] = $mediaID;
        $self['mediaURL'] = $mediaURL;

        return $self;
    }

    public function withMediaID(string $mediaID): self
    {
        $self = clone $this;
        $self['mediaID'] = $mediaID;

        return $self;
    }

    /**
     * Public media URL for tweet `media` arrays.
     */
    public function withMediaURL(string $mediaURL): self
    {
        $self = clone $this;
        $self['mediaURL'] = $mediaURL;

        return $self;
    }

    public function withSuccess(bool $success): self
    {
        $self = clone $this;
        $self['success'] = $success;

        return $self;
    }
}
