<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Dm;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Dm\DmGetHistoryResponse\Message;

/**
 * @phpstan-import-type MessageShape from \XTwitterScraper\X\Dm\DmGetHistoryResponse\Message
 *
 * @phpstan-type DmGetHistoryResponseShape = array{
 *   hasNextPage: bool, messages: list<Message|MessageShape>, nextCursor: string
 * }
 */
final class DmGetHistoryResponse implements BaseModel
{
    /** @use SdkModel<DmGetHistoryResponseShape> */
    use SdkModel;

    #[Required('has_next_page')]
    public bool $hasNextPage;

    /** @var list<Message> $messages */
    #[Required(list: Message::class)]
    public array $messages;

    #[Required('next_cursor')]
    public string $nextCursor;

    /**
     * `new DmGetHistoryResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DmGetHistoryResponse::with(hasNextPage: ..., messages: ..., nextCursor: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DmGetHistoryResponse)
     *   ->withHasNextPage(...)
     *   ->withMessages(...)
     *   ->withNextCursor(...)
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
     * @param list<Message|MessageShape> $messages
     */
    public static function with(
        bool $hasNextPage,
        array $messages,
        string $nextCursor
    ): self {
        $self = new self;

        $self['hasNextPage'] = $hasNextPage;
        $self['messages'] = $messages;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }

    public function withHasNextPage(bool $hasNextPage): self
    {
        $self = clone $this;
        $self['hasNextPage'] = $hasNextPage;

        return $self;
    }

    /**
     * @param list<Message|MessageShape> $messages
     */
    public function withMessages(array $messages): self
    {
        $self = clone $this;
        $self['messages'] = $messages;

        return $self;
    }

    public function withNextCursor(string $nextCursor): self
    {
        $self = clone $this;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }
}
