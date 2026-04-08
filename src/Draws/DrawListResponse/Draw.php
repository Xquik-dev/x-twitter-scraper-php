<?php

declare(strict_types=1);

namespace XTwitterScraper\Draws\DrawListResponse;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Giveaway draw summary with entry counts and status.
 *
 * @phpstan-type DrawShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   status: string,
 *   totalEntries: int,
 *   tweetURL: string,
 *   validEntries: int,
 *   drawnAt?: \DateTimeInterface|null,
 * }
 */
final class Draw implements BaseModel
{
    /** @use SdkModel<DrawShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public \DateTimeInterface $createdAt;

    #[Required]
    public string $status;

    #[Required]
    public int $totalEntries;

    #[Required('tweetUrl')]
    public string $tweetURL;

    #[Required]
    public int $validEntries;

    #[Optional]
    public ?\DateTimeInterface $drawnAt;

    /**
     * `new Draw()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Draw::with(
     *   id: ...,
     *   createdAt: ...,
     *   status: ...,
     *   totalEntries: ...,
     *   tweetURL: ...,
     *   validEntries: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Draw)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withStatus(...)
     *   ->withTotalEntries(...)
     *   ->withTweetURL(...)
     *   ->withValidEntries(...)
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
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        string $status,
        int $totalEntries,
        string $tweetURL,
        int $validEntries,
        ?\DateTimeInterface $drawnAt = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['status'] = $status;
        $self['totalEntries'] = $totalEntries;
        $self['tweetURL'] = $tweetURL;
        $self['validEntries'] = $validEntries;

        null !== $drawnAt && $self['drawnAt'] = $drawnAt;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withTotalEntries(int $totalEntries): self
    {
        $self = clone $this;
        $self['totalEntries'] = $totalEntries;

        return $self;
    }

    public function withTweetURL(string $tweetURL): self
    {
        $self = clone $this;
        $self['tweetURL'] = $tweetURL;

        return $self;
    }

    public function withValidEntries(int $validEntries): self
    {
        $self = clone $this;
        $self['validEntries'] = $validEntries;

        return $self;
    }

    public function withDrawnAt(\DateTimeInterface $drawnAt): self
    {
        $self = clone $this;
        $self['drawnAt'] = $drawnAt;

        return $self;
    }
}
