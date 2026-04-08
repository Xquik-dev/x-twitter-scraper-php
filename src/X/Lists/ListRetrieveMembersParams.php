<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Lists;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Get list members.
 *
 * @see XTwitterScraper\Services\X\ListsService::retrieveMembers()
 *
 * @phpstan-type ListRetrieveMembersParamsShape = array{cursor?: string|null}
 */
final class ListRetrieveMembersParams implements BaseModel
{
    /** @use SdkModel<ListRetrieveMembersParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Pagination cursor for list members.
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
     * Pagination cursor for list members.
     */
    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }
}
