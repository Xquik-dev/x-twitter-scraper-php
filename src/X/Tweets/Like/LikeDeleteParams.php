<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\Like;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Unlike tweet.
 *
 * @see XTwitterScraper\Services\X\Tweets\LikeService::delete()
 *
 * @phpstan-type LikeDeleteParamsShape = array{account: string}
 */
final class LikeDeleteParams implements BaseModel
{
    /** @use SdkModel<LikeDeleteParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * X account (@username or account ID).
     */
    #[Required]
    public string $account;

    /**
     * `new LikeDeleteParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * LikeDeleteParams::with(account: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new LikeDeleteParams)->withAccount(...)
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
    public static function with(string $account): self
    {
        $self = new self;

        $self['account'] = $account;

        return $self;
    }

    /**
     * X account (@username or account ID).
     */
    public function withAccount(string $account): self
    {
        $self = clone $this;
        $self['account'] = $account;

        return $self;
    }
}
