<?php

declare(strict_types=1);

namespace XTwitterScraper\Extractions;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Core\Conversion\MapOf;

/**
 * @phpstan-type ExtractionGetResponseShape = array{
 *   hasMore: bool,
 *   job: array<string,mixed>,
 *   results: list<array<string,mixed>>,
 *   nextCursor?: string|null,
 * }
 */
final class ExtractionGetResponse implements BaseModel
{
    /** @use SdkModel<ExtractionGetResponseShape> */
    use SdkModel;

    #[Required]
    public bool $hasMore;

    /** @var array<string,mixed> $job */
    #[Required(map: 'mixed')]
    public array $job;

    /** @var list<array<string,mixed>> $results */
    #[Required(list: new MapOf('mixed'))]
    public array $results;

    #[Optional]
    public ?string $nextCursor;

    /**
     * `new ExtractionGetResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ExtractionGetResponse::with(hasMore: ..., job: ..., results: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ExtractionGetResponse)->withHasMore(...)->withJob(...)->withResults(...)
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
     *
     * @param array<string,mixed> $job
     * @param list<array<string,mixed>> $results
     */
    public static function with(
        bool $hasMore,
        array $job,
        array $results,
        ?string $nextCursor = null
    ): self {
        $self = new self;

        $self['hasMore'] = $hasMore;
        $self['job'] = $job;
        $self['results'] = $results;

        null !== $nextCursor && $self['nextCursor'] = $nextCursor;

        return $self;
    }

    public function withHasMore(bool $hasMore): self
    {
        $self = clone $this;
        $self['hasMore'] = $hasMore;

        return $self;
    }

    /**
     * @param array<string,mixed> $job
     */
    public function withJob(array $job): self
    {
        $self = clone $this;
        $self['job'] = $job;

        return $self;
    }

    /**
     * @param list<array<string,mixed>> $results
     */
    public function withResults(array $results): self
    {
        $self = clone $this;
        $self['results'] = $results;

        return $self;
    }

    public function withNextCursor(string $nextCursor): self
    {
        $self = clone $this;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }
}
