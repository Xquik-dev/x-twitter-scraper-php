<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Communities;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Get community moderators.
 *
 * @see XTwitterScraper\Services\X\CommunitiesService::retrieveModerators()
 *
 * @phpstan-type CommunityRetrieveModeratorsParamsShape = array{
 *   cursor?: string|null
 * }
 */
final class CommunityRetrieveModeratorsParams implements BaseModel
{
    /** @use SdkModel<CommunityRetrieveModeratorsParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Pagination cursor for community moderators.
     */
    #[Optional]
    public ?string $cursor;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $cursor = null): self
    {
        $self = new self;

        null !== $cursor && $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Pagination cursor for community moderators.
     */
    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }
}
