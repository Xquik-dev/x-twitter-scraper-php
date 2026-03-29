<?php

declare(strict_types=1);

namespace XTwitterScraper\Drafts;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * List saved drafts.
 *
 * @see XTwitterScraper\Services\DraftsService::list()
 *
 * @phpstan-type DraftListParamsShape = array{
 *   afterCursor?: string|null, limit?: int|null
 * }
 */
final class DraftListParams implements BaseModel
{
    /** @use SdkModel<DraftListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Cursor for pagination.
     */
    #[Optional]
    public ?string $afterCursor;

    #[Optional]
    public ?int $limit;

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
        ?string $afterCursor = null,
        ?int $limit = null
    ): self {
        $self = new self;

        null !== $afterCursor && $self['afterCursor'] = $afterCursor;
        null !== $limit && $self['limit'] = $limit;

        return $self;
    }

    /**
     * Cursor for pagination.
     */
    public function withAfterCursor(string $afterCursor): self
    {
        $self = clone $this;
        $self['afterCursor'] = $afterCursor;

        return $self;
    }

    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }
}
