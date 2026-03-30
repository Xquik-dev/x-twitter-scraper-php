<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Followers;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Check follow relationship.
 *
 * @see XTwitterScraper\Services\X\FollowersService::check()
 *
 * @phpstan-type FollowerCheckParamsShape = array{source: string, target: string}
 */
final class FollowerCheckParams implements BaseModel
{
    /** @use SdkModel<FollowerCheckParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Username to check (without @).
     */
    #[Required]
    public string $source;

    /**
     * Target username (without @).
     */
    #[Required]
    public string $target;

    /**
     * `new FollowerCheckParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FollowerCheckParams::with(source: ..., target: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FollowerCheckParams)->withSource(...)->withTarget(...)
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
    public static function with(string $source, string $target): self
    {
        $self = new self;

        $self['source'] = $source;
        $self['target'] = $target;

        return $self;
    }

    /**
     * Username to check (without @).
     */
    public function withSource(string $source): self
    {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }

    /**
     * Target username (without @).
     */
    public function withTarget(string $target): self
    {
        $self = clone $this;
        $self['target'] = $target;

        return $self;
    }
}
