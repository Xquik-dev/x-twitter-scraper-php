<?php

declare(strict_types=1);

namespace XTwitterScraper\Styles;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Styles\StyleUpdateParams\Tweet;

/**
 * Save style profile with custom tweets.
 *
 * @see XTwitterScraper\Services\StylesService::update()
 *
 * @phpstan-import-type TweetShape from \XTwitterScraper\Styles\StyleUpdateParams\Tweet
 *
 * @phpstan-type StyleUpdateParamsShape = array{
 *   label: string, tweets: list<Tweet|TweetShape>
 * }
 */
final class StyleUpdateParams implements BaseModel
{
    /** @use SdkModel<StyleUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Display label for the style.
     */
    #[Required]
    public string $label;

    /**
     * Array of tweet objects.
     *
     * @var list<Tweet> $tweets
     */
    #[Required(list: Tweet::class)]
    public array $tweets;

    /**
     * `new StyleUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * StyleUpdateParams::with(label: ..., tweets: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new StyleUpdateParams)->withLabel(...)->withTweets(...)
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
     * @param list<Tweet|TweetShape> $tweets
     */
    public static function with(string $label, array $tweets): self
    {
        $self = new self;

        $self['label'] = $label;
        $self['tweets'] = $tweets;

        return $self;
    }

    /**
     * Display label for the style.
     */
    public function withLabel(string $label): self
    {
        $self = clone $this;
        $self['label'] = $label;

        return $self;
    }

    /**
     * Array of tweet objects.
     *
     * @param list<Tweet|TweetShape> $tweets
     */
    public function withTweets(array $tweets): self
    {
        $self = clone $this;
        $self['tweets'] = $tweets;

        return $self;
    }
}
