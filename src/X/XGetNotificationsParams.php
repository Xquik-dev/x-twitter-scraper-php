<?php

declare(strict_types=1);

namespace XTwitterScraper\X;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\XGetNotificationsParams\Type;

/**
 * Get notifications.
 *
 * @see XTwitterScraper\Services\XService::getNotifications()
 *
 * @phpstan-type XGetNotificationsParamsShape = array{
 *   cursor?: string|null, type?: null|Type|value-of<Type>
 * }
 */
final class XGetNotificationsParams implements BaseModel
{
    /** @use SdkModel<XGetNotificationsParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Pagination cursor from previous response.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Notification type filter.
     *
     * @var value-of<Type>|null $type
     */
    #[Optional(enum: Type::class)]
    public ?string $type;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Type|value-of<Type>|null $type
     */
    public static function with(
        ?string $cursor = null,
        Type|string|null $type = null
    ): self {
        $self = new self;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    /**
     * Pagination cursor from previous response.
     */
    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Notification type filter.
     *
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
