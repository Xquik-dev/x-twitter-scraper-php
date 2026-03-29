<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Communities;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Delete community.
 *
 * @see XTwitterScraper\Services\X\CommunitiesService::delete()
 *
 * @phpstan-type CommunityDeleteParamsShape = array{
 *   account: string, communityName: string
 * }
 */
final class CommunityDeleteParams implements BaseModel
{
    /** @use SdkModel<CommunityDeleteParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * X account (@username or account ID).
     */
    #[Required]
    public string $account;

    /**
     * Community name for confirmation.
     */
    #[Required('community_name')]
    public string $communityName;

    /**
     * `new CommunityDeleteParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CommunityDeleteParams::with(account: ..., communityName: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CommunityDeleteParams)->withAccount(...)->withCommunityName(...)
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
    public static function with(string $account, string $communityName): self
    {
        $self = new self;

        $self['account'] = $account;
        $self['communityName'] = $communityName;

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

    /**
     * Community name for confirmation.
     */
    public function withCommunityName(string $communityName): self
    {
        $self = clone $this;
        $self['communityName'] = $communityName;

        return $self;
    }
}
