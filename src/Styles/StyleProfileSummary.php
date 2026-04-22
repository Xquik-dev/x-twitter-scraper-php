<?php

declare(strict_types=1);

namespace XTwitterScraper\Styles;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Style profile summary with tweet count and ownership flag.
 *
 * @phpstan-type StyleProfileSummaryShape = array{
 *   fetchedAt: \DateTimeInterface,
 *   isOwnAccount: bool,
 *   tweetCount: int,
 *   xUsername: string,
 * }
 */
final class StyleProfileSummary implements BaseModel
{
    /** @use SdkModel<StyleProfileSummaryShape> */
    use SdkModel;

    #[Required]
    public \DateTimeInterface $fetchedAt;

    #[Required]
    public bool $isOwnAccount;

    #[Required]
    public int $tweetCount;

    #[Required]
    public string $xUsername;

    /**
     * `new StyleProfileSummary()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * StyleProfileSummary::with(
     *   fetchedAt: ..., isOwnAccount: ..., tweetCount: ..., xUsername: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new StyleProfileSummary)
     *   ->withFetchedAt(...)
     *   ->withIsOwnAccount(...)
     *   ->withTweetCount(...)
     *   ->withXUsername(...)
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
        \DateTimeInterface $fetchedAt,
        bool $isOwnAccount,
        int $tweetCount,
        string $xUsername,
    ): self {
        $self = new self;

        $self['fetchedAt'] = $fetchedAt;
        $self['isOwnAccount'] = $isOwnAccount;
        $self['tweetCount'] = $tweetCount;
        $self['xUsername'] = $xUsername;

        return $self;
    }

    public function withFetchedAt(\DateTimeInterface $fetchedAt): self
    {
        $self = clone $this;
        $self['fetchedAt'] = $fetchedAt;

        return $self;
    }

    public function withIsOwnAccount(bool $isOwnAccount): self
    {
        $self = clone $this;
        $self['isOwnAccount'] = $isOwnAccount;

        return $self;
    }

    public function withTweetCount(int $tweetCount): self
    {
        $self = clone $this;
        $self['tweetCount'] = $tweetCount;

        return $self;
    }

    public function withXUsername(string $xUsername): self
    {
        $self = clone $this;
        $self['xUsername'] = $xUsername;

        return $self;
    }
}
