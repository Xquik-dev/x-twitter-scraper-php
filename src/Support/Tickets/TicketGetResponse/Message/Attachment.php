<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Support\Tickets\TicketGetResponse\Message;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Support\Tickets\TicketGetResponse\Message\Attachment\ContentType;
use XTwitterScraper\Support\Tickets\TicketGetResponse\Message\Attachment\Kind;
use XTwitterScraper\Support\Tickets\TicketGetResponse\Message\Attachment\Status;

/**
 * Downloadable image or video attached to a support message.
 *
 * @phpstan-type AttachmentShape = array{
 *   contentType: ContentType|value-of<ContentType>,
 *   filename: string,
 *   kind: Kind|value-of<Kind>,
 *   publicID: string,
 *   sizeBytes: int,
 *   status: Status|value-of<Status>,
 *   url: string,
 * }
 */
final class Attachment implements BaseModel
{
    /** @use SdkModel<AttachmentShape> */
    use SdkModel;

    /**
     * Validated media type.
     *
     * @var value-of<ContentType> $contentType
     */
    #[Required(enum: ContentType::class)]
    public string $contentType;

    #[Required]
    public string $filename;

    /**
     * Attachment media class.
     *
     * @var value-of<Kind> $kind
     */
    #[Required(enum: Kind::class)]
    public string $kind;

    #[Required('publicId')]
    public string $publicID;

    #[Required]
    public int $sizeBytes;

    /**
     * Storage processing state.
     *
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    #[Required]
    public string $url;

    /**
     * `new Attachment()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Attachment::with(
     *   contentType: ...,
     *   filename: ...,
     *   kind: ...,
     *   publicID: ...,
     *   sizeBytes: ...,
     *   status: ...,
     *   url: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Attachment)
     *   ->withContentType(...)
     *   ->withFilename(...)
     *   ->withKind(...)
     *   ->withPublicID(...)
     *   ->withSizeBytes(...)
     *   ->withStatus(...)
     *   ->withURL(...)
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
     *
     * @param ContentType|value-of<ContentType> $contentType
     * @param Kind|value-of<Kind> $kind
     * @param Status|value-of<Status> $status
     */
    public static function with(
        ContentType|string $contentType,
        string $filename,
        Kind|string $kind,
        string $publicID,
        int $sizeBytes,
        Status|string $status,
        string $url,
    ): self {
        $self = new self;

        $self['contentType'] = $contentType;
        $self['filename'] = $filename;
        $self['kind'] = $kind;
        $self['publicID'] = $publicID;
        $self['sizeBytes'] = $sizeBytes;
        $self['status'] = $status;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Validated media type.
     *
     * @param ContentType|value-of<ContentType> $contentType
     */
    public function withContentType(ContentType|string $contentType): self
    {
        $self = clone $this;
        $self['contentType'] = $contentType;

        return $self;
    }

    public function withFilename(string $filename): self
    {
        $self = clone $this;
        $self['filename'] = $filename;

        return $self;
    }

    /**
     * Attachment media class.
     *
     * @param Kind|value-of<Kind> $kind
     */
    public function withKind(Kind|string $kind): self
    {
        $self = clone $this;
        $self['kind'] = $kind;

        return $self;
    }

    public function withPublicID(string $publicID): self
    {
        $self = clone $this;
        $self['publicID'] = $publicID;

        return $self;
    }

    public function withSizeBytes(int $sizeBytes): self
    {
        $self = clone $this;
        $self['sizeBytes'] = $sizeBytes;

        return $self;
    }

    /**
     * Storage processing state.
     *
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
