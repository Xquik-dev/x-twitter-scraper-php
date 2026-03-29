<?php

declare(strict_types=1);

namespace XTwitterScraper\Styles\StyleAnalyzeResponse;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type TweetShape = array{
 *   id: string,
 *   text: string,
 *   authorUsername?: string|null,
 *   createdAt?: string|null,
 * }
 */
final class Tweet implements BaseModel
{
    /** @use SdkModel<TweetShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public string $text;

    #[Optional]
    public ?string $authorUsername;

    #[Optional]
    public ?string $createdAt;

    /**
     * `new Tweet()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Tweet::with(id: ..., text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Tweet)->withID(...)->withText(...)
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
        string $text,
        ?string $authorUsername = null,
        ?string $createdAt = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['text'] = $text;

        null !== $authorUsername && $self['authorUsername'] = $authorUsername;
        null !== $createdAt && $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    public function withAuthorUsername(string $authorUsername): self
    {
        $self = clone $this;
        $self['authorUsername'] = $authorUsername;

        return $self;
    }

    public function withCreatedAt(string $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }
}
