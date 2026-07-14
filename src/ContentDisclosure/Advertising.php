<?php

declare(strict_types=1);

namespace XTwitterScraper\ContentDisclosure;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type AdvertisingShape = array{isPaidPromotion?: bool|null}
 */
final class Advertising implements BaseModel
{
    /** @use SdkModel<AdvertisingShape> */
    use SdkModel;

    /**
     * True when X labels the tweet as paid promotion content.
     */
    #[Optional]
    public ?bool $isPaidPromotion;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?bool $isPaidPromotion = null): self
    {
        $self = new self;

        null !== $isPaidPromotion && $self['isPaidPromotion'] = $isPaidPromotion;

        return $self;
    }

    /**
     * True when X labels the tweet as paid promotion content.
     */
    public function withIsPaidPromotion(bool $isPaidPromotion): self
    {
        $self = clone $this;
        $self['isPaidPromotion'] = $isPaidPromotion;

        return $self;
    }
}
