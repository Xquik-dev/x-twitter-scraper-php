<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Users\Follow;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Unfollow user.
 *
 * @see XTwitterScraper\Services\X\Users\FollowService::deleteAll()
 *
 * @phpstan-type FollowDeleteAllParamsShape = array{account: string}
 */
final class FollowDeleteAllParams implements BaseModel
{
    /** @use SdkModel<FollowDeleteAllParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * X account (@username or account ID).
     */
    #[Required]
    public string $account;

    /**
     * `new FollowDeleteAllParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FollowDeleteAllParams::with(account: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FollowDeleteAllParams)->withAccount(...)
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
