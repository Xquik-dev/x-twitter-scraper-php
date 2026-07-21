<?php

declare(strict_types=1);

namespace XTwitterScraper\Support\Tickets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Support\Tickets\TicketNewResponse\Attachment;

/**
 * @phpstan-import-type AttachmentShape from \XTwitterScraper\Support\Tickets\TicketNewResponse\Attachment
 *
 * @phpstan-type TicketNewResponseShape = array{
 *   attachments?: list<Attachment|AttachmentShape>|null, publicID?: string|null
 * }
 */
final class TicketNewResponse implements BaseModel
{
    /** @use SdkModel<TicketNewResponseShape> */
    use SdkModel;

    /** @var list<Attachment>|null $attachments */
    #[Optional(list: Attachment::class)]
    public ?array $attachments;

    #[Optional('publicId')]
    public ?string $publicID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<Attachment|AttachmentShape>|null $attachments
     */
    public static function with(
        ?array $attachments = null,
        ?string $publicID = null
    ): self {
        $self = new self;

        null !== $attachments && $self['attachments'] = $attachments;
        null !== $publicID && $self['publicID'] = $publicID;

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
