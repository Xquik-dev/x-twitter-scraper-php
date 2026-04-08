<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Delete tweet.
 *
 * @see XTwitterScraper\Services\X\TweetsService::delete()
 *
 * @phpstan-type TweetDeleteParamsShape = array{account: string}
 */
final class TweetDeleteParams implements BaseModel
{
    /** @use SdkModel<TweetDeleteParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * X account identifier (@username or account ID).
     */
    #[Required]
    public string $account;

    /**
     * `new TweetDeleteParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetDeleteParams::with(account: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetDeleteParams)->withAccount(...)
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
     * X account identifier (@username or account ID).
     */
    public function withAccount(string $account): self
    {
        $self = clone $this;
        $self['account'] = $account;

        return $self;
    }
}
