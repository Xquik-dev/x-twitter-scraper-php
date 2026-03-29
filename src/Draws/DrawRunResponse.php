<?php

declare(strict_types=1);

namespace XTwitterScraper\Draws;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Draws\DrawRunResponse\Winner;

/**
 * @phpstan-import-type WinnerShape from \XTwitterScraper\Draws\DrawRunResponse\Winner
 *
 * @phpstan-type DrawRunResponseShape = array{
 *   id: string,
 *   totalEntries: int,
 *   tweetID: string,
 *   validEntries: int,
 *   winners: list<Winner|WinnerShape>,
 * }
 */
final class DrawRunResponse implements BaseModel
{
    /** @use SdkModel<DrawRunResponseShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public int $totalEntries;

    #[Required('tweetId')]
    public string $tweetID;

    #[Required]
    public int $validEntries;

    /** @var list<Winner> $winners */
    #[Required(list: Winner::class)]
    public array $winners;

    /**
     * `new DrawRunResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DrawRunResponse::with(
     *   id: ..., totalEntries: ..., tweetID: ..., validEntries: ..., winners: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DrawRunResponse)
     *   ->withID(...)
     *   ->withTotalEntries(...)
     *   ->withTweetID(...)
     *   ->withValidEntries(...)
     *   ->withWinners(...)
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
     * @param list<Winner|WinnerShape> $winners
     */
    public static function with(
        string $id,
        int $totalEntries,
        string $tweetID,
        int $validEntries,
        array $winners,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['totalEntries'] = $totalEntries;
        $self['tweetID'] = $tweetID;
        $self['validEntries'] = $validEntries;
        $self['winners'] = $winners;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withTotalEntries(int $totalEntries): self
    {
        $self = clone $this;
        $self['totalEntries'] = $totalEntries;

        return $self;
    }

    public function withTweetID(string $tweetID): self
    {
        $self = clone $this;
        $self['tweetID'] = $tweetID;

        return $self;
    }

    public function withValidEntries(int $validEntries): self
    {
        $self = clone $this;
        $self['validEntries'] = $validEntries;

        return $self;
    }

    /**
     * @param list<Winner|WinnerShape> $winners
     */
    public function withWinners(array $winners): self
    {
        $self = clone $this;
        $self['winners'] = $winners;

        return $self;
    }
}
