<?php

declare(strict_types=1);

namespace XTwitterScraper\Bot;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type BotTrackUsageResponseShape = array{success?: bool|null}
 */
final class BotTrackUsageResponse implements BaseModel
{
    /** @use SdkModel<BotTrackUsageResponseShape> */
    use SdkModel;

    #[Optional]
    public ?bool $success;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?bool $success = null): self
    {
        $self = new self;

        null !== $success && $self['success'] = $success;

        return $self;
    }

    public function withSuccess(bool $success): self
    {
        $self = clone $this;
        $self['success'] = $success;

        return $self;
    }
}
