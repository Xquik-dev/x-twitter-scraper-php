<?php

declare(strict_types=1);

namespace XTwitterScraper\Credits;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Credits\CreditGetTopupStatusResponse\Status;

/**
 * @phpstan-type CreditGetTopupStatusResponseShape = array{
 *   status: Status|value-of<Status>,
 *   amountDollars?: int|null,
 *   credits?: string|null,
 * }
 */
final class CreditGetTopupStatusResponse implements BaseModel
{
    /** @use SdkModel<CreditGetTopupStatusResponseShape> */
    use SdkModel;

    /** @var value-of<Status> $status */
    #[Required(enum: Status::class)]
    public string $status;

    /**
     * Dollar amount requested for the top-up.
     */
    #[Optional('amount_dollars', nullable: true)]
    public ?int $amountDollars;

    /**
     * Bigint string credit amount granted or pending.
     */
    #[Optional]
    public ?string $credits;

    /**
     * `new CreditGetTopupStatusResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CreditGetTopupStatusResponse::with(status: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CreditGetTopupStatusResponse)->withStatus(...)
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
     * @param Status|value-of<Status> $status
     */
    public static function with(
        Status|string $status,
        ?int $amountDollars = null,
        ?string $credits = null
    ): self {
        $self = new self;

        $self['status'] = $status;

        null !== $amountDollars && $self['amountDollars'] = $amountDollars;
        null !== $credits && $self['credits'] = $credits;

        return $self;
    }

    /**
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * Dollar amount requested for the top-up.
     */
    public function withAmountDollars(?int $amountDollars): self
    {
        $self = clone $this;
        $self['amountDollars'] = $amountDollars;

        return $self;
    }

    /**
     * Bigint string credit amount granted or pending.
     */
    public function withCredits(string $credits): self
    {
        $self = clone $this;
        $self['credits'] = $credits;

        return $self;
    }
}
