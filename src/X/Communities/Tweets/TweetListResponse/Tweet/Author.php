<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Communities\Tweets\TweetListResponse\Tweet;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type AuthorShape = array{
 *   id: string, name: string, username: string, verified?: bool|null
 * }
 */
final class Author implements BaseModel
{
    /** @use SdkModel<AuthorShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public string $name;

    #[Required]
    public string $username;

    #[Optional]
    public ?bool $verified;

    /**
     * `new Author()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Author::with(id: ..., name: ..., username: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Author)->withID(...)->withName(...)->withUsername(...)
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
        string $name,
        string $username,
        ?bool $verified = null
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['name'] = $name;
        $self['username'] = $username;

        null !== $verified && $self['verified'] = $verified;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withUsername(string $username): self
    {
        $self = clone $this;
        $self['username'] = $username;

        return $self;
    }

    public function withVerified(bool $verified): self
    {
        $self = clone $this;
        $self['verified'] = $verified;

        return $self;
    }
}
