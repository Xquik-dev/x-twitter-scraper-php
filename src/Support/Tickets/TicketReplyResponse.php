<?php

declare(strict_types=1);

namespace XTwitterScraper\Support\Tickets;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Support\Tickets\TicketReplyResponse\Attachment;

/**
 * @phpstan-import-type AttachmentShape from \XTwitterScraper\Support\Tickets\TicketReplyResponse\Attachment
 *
 * @phpstan-type TicketReplyResponseShape = array{
 *   attachments: list<Attachment|AttachmentShape>, publicID: string
 * }
 */
final class TicketReplyResponse implements BaseModel
{
    /** @use SdkModel<TicketReplyResponseShape> */
    use SdkModel;

    /** @var list<Attachment> $attachments */
    #[Required(list: Attachment::class)]
    public array $attachments;

    #[Required('publicId')]
    public string $publicID;

    /**
     * `new TicketReplyResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TicketReplyResponse::with(attachments: ..., publicID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TicketReplyResponse)->withAttachments(...)->withPublicID(...)
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
     * @param list<Attachment|AttachmentShape> $attachments
     */
    public static function with(array $attachments, string $publicID): self
    {
        $self = new self;

        $self['attachments'] = $attachments;
        $self['publicID'] = $publicID;

        return $self;
    }

    /**
     * @param list<Attachment|AttachmentShape> $attachments
     */
    public function withAttachments(array $attachments): self
    {
        $self = clone $this;
        $self['attachments'] = $attachments;

        return $self;
    }

    public function withPublicID(string $publicID): self
    {
        $self = clone $this;
        $self['publicID'] = $publicID;

        return $self;
    }
}
