<?php

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\TweetMedia\Type;
use XTwitterScraper\TweetMedia\VideoVariant;

/**
 * Normalized media attached to a tweet.
 *
 * @phpstan-import-type VideoVariantShape from \XTwitterScraper\TweetMedia\VideoVariant
 *
 * @phpstan-type TweetMediaShape = array{
 *   mediaURL: string,
 *   type: Type|value-of<Type>,
 *   url: string,
 *   videoVariants?: list<VideoVariant|VideoVariantShape>|null,
 * }
 */
final class TweetMedia implements BaseModel
{
    /** @use SdkModel<TweetMediaShape> */
    use SdkModel;

    /**
     * Media preview URL.
     */
    #[Required('mediaUrl')]
    public string $mediaURL;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * X media link from the tweet.
     */
    #[Required]
    public string $url;

    /**
     * Available video encodings, ordered as returned.
     *
     * @var list<VideoVariant>|null $videoVariants
     */
    #[Optional(list: VideoVariant::class)]
    public ?array $videoVariants;

    /**
     * `new TweetMedia()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetMedia::with(mediaURL: ..., type: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetMedia)->withMediaURL(...)->withType(...)->withURL(...)
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
     * @param Type|value-of<Type> $type
     * @param list<VideoVariant|VideoVariantShape>|null $videoVariants
     */
    public static function with(
        string $mediaURL,
        Type|string $type,
        string $url,
        ?array $videoVariants = null,
    ): self {
        $self = new self;

        $self['mediaURL'] = $mediaURL;
        $self['type'] = $type;
        $self['url'] = $url;

        null !== $videoVariants && $self['videoVariants'] = $videoVariants;

        return $self;
    }

    /**
     * Media preview URL.
     */
    public function withMediaURL(string $mediaURL): self
    {
        $self = clone $this;
        $self['mediaURL'] = $mediaURL;

        return $self;
    }

    /**
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * X media link from the tweet.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Available video encodings, ordered as returned.
     *
     * @param list<VideoVariant|VideoVariantShape> $videoVariants
     */
    public function withVideoVariants(array $videoVariants): self
    {
        $self = clone $this;
        $self['videoVariants'] = $videoVariants;

        return $self;
    }
}
