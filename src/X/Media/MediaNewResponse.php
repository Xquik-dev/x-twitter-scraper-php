<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Media;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type MediaNewResponseShape = array{mediaID: string, success: bool}
 */
final class MediaNewResponse implements BaseModel
{
    /** @use SdkModel<MediaNewResponseShape> */
    use SdkModel;

    #[Required]
    public bool $success = true;

    #[Required('mediaId')]
    public string $mediaID;

    /**
     * `new MediaNewResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MediaNewResponse::with(mediaID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MediaNewResponse)->withMediaID(...)
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
    public static function with(string $mediaID): self
    {
        $self = new self;

        $self['mediaID'] = $mediaID;

        return $self;
    }

    public function withMediaID(string $mediaID): self
    {
        $self = clone $this;
        $self['mediaID'] = $mediaID;

        return $self;
    }

    public function withSuccess(bool $success): self
    {
        $self = clone $this;
        $self['success'] = $success;

        return $self;
    }
}
