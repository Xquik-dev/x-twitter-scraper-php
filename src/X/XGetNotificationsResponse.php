<?php

declare(strict_types=1);

namespace XTwitterScraper\X;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\XGetNotificationsResponse\Notification;

/**
 * @phpstan-import-type NotificationShape from \XTwitterScraper\X\XGetNotificationsResponse\Notification
 *
 * @phpstan-type XGetNotificationsResponseShape = array{
 *   hasNextPage: bool,
 *   nextCursor: string,
 *   notifications: list<Notification|NotificationShape>,
 * }
 */
final class XGetNotificationsResponse implements BaseModel
{
    /** @use SdkModel<XGetNotificationsResponseShape> */
    use SdkModel;

    #[Required('has_next_page')]
    public bool $hasNextPage;

    #[Required('next_cursor')]
    public string $nextCursor;

    /** @var list<Notification> $notifications */
    #[Required(list: Notification::class)]
    public array $notifications;

    /**
     * `new XGetNotificationsResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * XGetNotificationsResponse::with(
     *   hasNextPage: ..., nextCursor: ..., notifications: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new XGetNotificationsResponse)
     *   ->withHasNextPage(...)
     *   ->withNextCursor(...)
     *   ->withNotifications(...)
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
     * @param list<Notification|NotificationShape> $notifications
     */
    public static function with(
        bool $hasNextPage,
        string $nextCursor,
        array $notifications
    ): self {
        $self = new self;

        $self['hasNextPage'] = $hasNextPage;
        $self['nextCursor'] = $nextCursor;
        $self['notifications'] = $notifications;

        return $self;
    }

    public function withHasNextPage(bool $hasNextPage): self
    {
        $self = clone $this;
        $self['hasNextPage'] = $hasNextPage;

        return $self;
    }

    public function withNextCursor(string $nextCursor): self
    {
        $self = clone $this;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }

    /**
     * @param list<Notification|NotificationShape> $notifications
     */
    public function withNotifications(array $notifications): self
    {
        $self = clone $this;
        $self['notifications'] = $notifications;

        return $self;
    }
}
