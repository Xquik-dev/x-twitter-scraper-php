<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Subscribe;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Currency;
use XTwitterScraper\Subscribe\SubscribeNewResponse\Status;

/**
 * @phpstan-type SubscribeNewResponseShape = array{
 *   message: string, status: Status|value-of<Status>, url: string,
 *   chargedCurrency?: Currency|value-of<Currency>|null,
 * }
 */
final class SubscribeNewResponse implements BaseModel
{
    /** @use SdkModel<SubscribeNewResponseShape> */
    use SdkModel;

    #[Required]
    public string $message;

    /** @var value-of<Status> $status */
    #[Required(enum: Status::class)]
    public string $status;

    #[Required]
    public string $url;

    /**
     * Currency the checkout charges. Only a checkout_created answer has it.
     *
     * @var value-of<Currency>|null $chargedCurrency
     */
    #[Optional(enum: Currency::class)]
    public ?string $chargedCurrency;

    /**
     * `new SubscribeNewResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SubscribeNewResponse::with(message: ..., status: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SubscribeNewResponse)->withMessage(...)->withStatus(...)->withURL(...)
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
     * @param Currency|value-of<Currency>|null $chargedCurrency
     */
    public static function with(
        string $message,
        Status|string $status,
        string $url,
        Currency|string|null $chargedCurrency = null
    ): self {
        $self = new self;

        $self['message'] = $message;
        $self['status'] = $status;
        $self['url'] = $url;

        null !== $chargedCurrency && $self['chargedCurrency'] = $chargedCurrency;

        return $self;
    }

    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

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

    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Currency the checkout charges. Only a checkout_created answer has it.
     *
     * @param Currency|value-of<Currency>|null $chargedCurrency
     */
    public function withChargedCurrency(Currency|string|null $chargedCurrency): self
    {
        $self = clone $this;
        $self['chargedCurrency'] = $chargedCurrency;

        return $self;
    }
}
