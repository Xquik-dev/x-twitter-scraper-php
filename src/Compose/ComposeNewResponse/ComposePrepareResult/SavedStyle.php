<?php

declare(strict_types=1);

namespace XTwitterScraper\Compose\ComposeNewResponse\ComposePrepareResult;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type SavedStyleShape = array{tweetCount: int, username: string}
 */
final class SavedStyle implements BaseModel
{
    /** @use SdkModel<SavedStyleShape> */
    use SdkModel;

    #[Required]
    public int $tweetCount;

    #[Required]
    public string $username;

    /**
     * `new SavedStyle()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SavedStyle::with(tweetCount: ..., username: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SavedStyle)->withTweetCount(...)->withUsername(...)
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
    public static function with(int $tweetCount, string $username): self
    {
        $self = new self;

        $self['tweetCount'] = $tweetCount;
        $self['username'] = $username;

        return $self;
    }

    public function withTweetCount(int $tweetCount): self
    {
        $self = clone $this;
        $self['tweetCount'] = $tweetCount;

        return $self;
    }

    public function withUsername(string $username): self
    {
        $self = clone $this;
        $self['username'] = $username;

        return $self;
    }
}
