<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type TweetDeleteResponseShape = array{success: bool}
 */
final class TweetDeleteResponse implements BaseModel
{
    /** @use SdkModel<TweetDeleteResponseShape> */
    use SdkModel;

    #[Required]
    public bool $success = true;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(): self
    {
        return new self;
    }

    public function withSuccess(bool $success): self
    {
        $self = clone $this;
        $self['success'] = $success;

        return $self;
    }
}
