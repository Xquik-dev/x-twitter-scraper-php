<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Dm;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Get DM conversation history.
 *
 * @see XTwitterScraper\Services\X\DmService::retrieveHistory()
 *
 * @phpstan-type DmRetrieveHistoryParamsShape = array{
 *   cursor?: string|null, maxID?: string|null
 * }
 */
final class DmRetrieveHistoryParams implements BaseModel
{
    /** @use SdkModel<DmRetrieveHistoryParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Pagination cursor from previous response.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Legacy pagination cursor (backward compat).
     */
    #[Optional]
    public ?string $maxID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        ?string $cursor = null,
        ?string $maxID = null
    ): self {
        $self = new self;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $maxID && $self['maxID'] = $maxID;

        return $self;
    }

    /**
     * Pagination cursor from previous response.
     */
    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Legacy pagination cursor (backward compat).
     */
    public function withMaxID(string $maxID): self
    {
        $self = clone $this;
        $self['maxID'] = $maxID;

        return $self;
    }
}
