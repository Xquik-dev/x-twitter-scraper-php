<?php

declare(strict_types=1);

namespace XTwitterScraper\Integrations\IntegrationListDeliveriesResponse;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Integration delivery attempt record with status and retry count.
 *
 * @phpstan-type DeliveryShape = array{
 *   id: string,
 *   attempts: int,
 *   createdAt: \DateTimeInterface,
 *   eventType: string,
 *   status: string,
 *   deliveredAt?: \DateTimeInterface|null,
 *   lastError?: string|null,
 *   lastStatusCode?: int|null,
 *   sourceID?: string|null,
 *   sourceType?: string|null,
 * }
 */
final class Delivery implements BaseModel
{
    /** @use SdkModel<DeliveryShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public int $attempts;

    #[Required]
    public \DateTimeInterface $createdAt;

    #[Required]
    public string $eventType;

    #[Required]
    public string $status;

    #[Optional]
    public ?\DateTimeInterface $deliveredAt;

    #[Optional]
    public ?string $lastError;

    #[Optional]
    public ?int $lastStatusCode;

    #[Optional('sourceId')]
    public ?string $sourceID;

    #[Optional]
    public ?string $sourceType;

    /**
     * `new Delivery()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Delivery::with(
     *   id: ..., attempts: ..., createdAt: ..., eventType: ..., status: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Delivery)
     *   ->withID(...)
     *   ->withAttempts(...)
     *   ->withCreatedAt(...)
     *   ->withEventType(...)
     *   ->withStatus(...)
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
        string $id,
        int $attempts,
        \DateTimeInterface $createdAt,
        string $eventType,
        string $status,
        ?\DateTimeInterface $deliveredAt = null,
        ?string $lastError = null,
        ?int $lastStatusCode = null,
        ?string $sourceID = null,
        ?string $sourceType = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['attempts'] = $attempts;
        $self['createdAt'] = $createdAt;
        $self['eventType'] = $eventType;
        $self['status'] = $status;

        null !== $deliveredAt && $self['deliveredAt'] = $deliveredAt;
        null !== $lastError && $self['lastError'] = $lastError;
        null !== $lastStatusCode && $self['lastStatusCode'] = $lastStatusCode;
        null !== $sourceID && $self['sourceID'] = $sourceID;
        null !== $sourceType && $self['sourceType'] = $sourceType;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withAttempts(int $attempts): self
    {
        $self = clone $this;
        $self['attempts'] = $attempts;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withEventType(string $eventType): self
    {
        $self = clone $this;
        $self['eventType'] = $eventType;

        return $self;
    }

    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withDeliveredAt(\DateTimeInterface $deliveredAt): self
    {
        $self = clone $this;
        $self['deliveredAt'] = $deliveredAt;

        return $self;
    }

    public function withLastError(string $lastError): self
    {
        $self = clone $this;
        $self['lastError'] = $lastError;

        return $self;
    }

    public function withLastStatusCode(int $lastStatusCode): self
    {
        $self = clone $this;
        $self['lastStatusCode'] = $lastStatusCode;

        return $self;
    }

    public function withSourceID(string $sourceID): self
    {
        $self = clone $this;
        $self['sourceID'] = $sourceID;

        return $self;
    }

    public function withSourceType(string $sourceType): self
    {
        $self = clone $this;
        $self['sourceType'] = $sourceType;

        return $self;
    }
}
