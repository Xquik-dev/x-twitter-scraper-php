<?php

declare(strict_types=1);

namespace XTwitterScraper\X\XGetArticleResponse;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type AuthorShape = array{
 *   id: string,
 *   followers: int,
 *   username: string,
 *   verified: bool,
 *   profilePicture?: string|null,
 * }
 */
final class Author implements BaseModel
{
    /** @use SdkModel<AuthorShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public int $followers;

    #[Required]
    public string $username;

    #[Required]
    public bool $verified;

    #[Optional]
    public ?string $profilePicture;

    /**
     * `new Author()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Author::with(id: ..., followers: ..., username: ..., verified: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Author)
     *   ->withID(...)
     *   ->withFollowers(...)
     *   ->withUsername(...)
     *   ->withVerified(...)
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
        int $followers,
        string $username,
        bool $verified,
        ?string $profilePicture = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['followers'] = $followers;
        $self['username'] = $username;
        $self['verified'] = $verified;

        null !== $profilePicture && $self['profilePicture'] = $profilePicture;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withFollowers(int $followers): self
    {
        $self = clone $this;
        $self['followers'] = $followers;

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

    public function withProfilePicture(string $profilePicture): self
    {
        $self = clone $this;
        $self['profilePicture'] = $profilePicture;

        return $self;
    }
}
