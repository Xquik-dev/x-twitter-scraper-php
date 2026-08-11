<?php

declare(strict_types=1);

namespace XTwitterScraper\Support\Attachments;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Streams an authenticated user's support image or video. Video requests support one standard byte range for seeking and resumable playback.
 *
 * @see XTwitterScraper\Services\Support\AttachmentsService::download()
 *
 * @phpstan-type AttachmentDownloadParamsShape = array{range?: string|null}
 */
final class AttachmentDownloadParams implements BaseModel
{
    /** @use SdkModel<AttachmentDownloadParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Optional]
    public ?string $range;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $range = null): self
    {
        $self = new self;

        null !== $range && $self['range'] = $range;

        return $self;
    }

    public function withRange(string $range): self
    {
        $self = clone $this;
        $self['range'] = $range;

        return $self;
    }
}
