<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Users\Follow;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type FollowNewResponseShape = array{success: bool}
 */
final class FollowNewResponse implements BaseModel
{
    /** @use SdkModel<FollowNewResponseShape> */
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
