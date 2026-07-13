<?php

declare(strict_types=1);

namespace XTwitterScraper\X\WriteActions\WriteActionGetResponse;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\WriteActions\WriteActionGetResponse\Media\Kind;

/**
 * @phpstan-type MediaShape = array{
 *   count: int, credits: string, kind: Kind|value-of<Kind>, totalBytes: string
 * }
 */
final class Media implements BaseModel
{
    /** @use SdkModel<MediaShape> */
    use SdkModel;

    #[Required]
    public int $count;

    #[Required]
    public string $credits;

    /** @var value-of<Kind> $kind */
    #[Required(enum: Kind::class)]
    public string $kind;

    #[Required]
    public string $totalBytes;

    /**
     * `new Media()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Media::with(count: ..., credits: ..., kind: ..., totalBytes: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Media)
     *   ->withCount(...)
     *   ->withCredits(...)
     *   ->withKind(...)
     *   ->withTotalBytes(...)
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
     * @param Kind|value-of<Kind> $kind
     */
    public static function with(
        int $count,
        string $credits,
        Kind|string $kind,
        string $totalBytes
    ): self {
        $self = new self;

        $self['count'] = $count;
        $self['credits'] = $credits;
        $self['kind'] = $kind;
        $self['totalBytes'] = $totalBytes;

        return $self;
    }

    public function withCount(int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

        return $self;
    }

    public function withCredits(string $credits): self
    {
        $self = clone $this;
        $self['credits'] = $credits;

        return $self;
    }

    /**
     * @param Kind|value-of<Kind> $kind
     */
    public function withKind(Kind|string $kind): self
    {
        $self = clone $this;
        $self['kind'] = $kind;

        return $self;
    }

    public function withTotalBytes(string $totalBytes): self
    {
        $self = clone $this;
        $self['totalBytes'] = $totalBytes;

        return $self;
    }
}
