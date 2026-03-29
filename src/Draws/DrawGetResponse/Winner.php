<?php

declare(strict_types=1);

namespace XTwitterScraper\Draws\DrawGetResponse;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type WinnerShape = array{
 *   authorUsername: string, isBackup: bool, position: int, tweetID: string
 * }
 */
final class Winner implements BaseModel
{
    /** @use SdkModel<WinnerShape> */
    use SdkModel;

    #[Required]
    public string $authorUsername;

    #[Required]
    public bool $isBackup;

    #[Required]
    public int $position;

    #[Required('tweetId')]
    public string $tweetID;

    /**
     * `new Winner()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Winner::with(authorUsername: ..., isBackup: ..., position: ..., tweetID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Winner)
     *   ->withAuthorUsername(...)
     *   ->withIsBackup(...)
     *   ->withPosition(...)
     *   ->withTweetID(...)
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
        string $authorUsername,
        bool $isBackup,
        int $position,
        string $tweetID
    ): self {
        $self = new self;

        $self['authorUsername'] = $authorUsername;
        $self['isBackup'] = $isBackup;
        $self['position'] = $position;
        $self['tweetID'] = $tweetID;

        return $self;
    }

    public function withAuthorUsername(string $authorUsername): self
    {
        $self = clone $this;
        $self['authorUsername'] = $authorUsername;

        return $self;
    }

    public function withIsBackup(bool $isBackup): self
    {
        $self = clone $this;
        $self['isBackup'] = $isBackup;

        return $self;
    }

    public function withPosition(int $position): self
    {
        $self = clone $this;
        $self['position'] = $position;

        return $self;
    }

    public function withTweetID(string $tweetID): self
    {
        $self = clone $this;
        $self['tweetID'] = $tweetID;

        return $self;
    }
}
