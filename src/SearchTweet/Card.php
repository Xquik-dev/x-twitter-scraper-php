<?php

declare(strict_types=1);

namespace XTwitterScraper\SearchTweet;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\SearchTweet\Card\UserReferenceErrors;
use XTwitterScraper\UserProfile;

/**
 * Public card metadata attached to a tweet.
 *
 * @phpstan-type CardShape = array{
 *   id?: string|null,
 *   bindingValues?: array<string,mixed>|null,
 *   name?: string|null,
 *   url?: string|null,
 *   platform?: array<string,mixed>|null,
 *   userReferenceErrors?: list<UserReferenceErrors|array<string,mixed>>|null,
 *   userReferences?: list<UserProfile|array<string,mixed>>|null,
 * }
 */
final class Card implements BaseModel
{
    /** @use SdkModel<CardShape> */
    use SdkModel;

    #[Optional]
    public ?string $id;

    /** @var array<string,mixed>|null $bindingValues */
    #[Optional(map: 'mixed')]
    public ?array $bindingValues;

    #[Optional]
    public ?string $name;

    #[Optional]
    public ?string $url;

    /**
     * Public metadata whose fields X defines.
     *
     * @var array<string,mixed>|null $platform
     */
    #[Optional(map: 'mixed')]
    public ?array $platform;

    /**
     * Unresolved card user references.
     *
     * @var list<UserReferenceErrors>|null $userReferenceErrors
     */
    #[Optional(list: UserReferenceErrors::class)]
    public ?array $userReferenceErrors;

    /**
     * @var list<UserProfile>|null $userReferences
     */
    #[Optional(list: UserProfile::class)]
    public ?array $userReferences;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param array<string,mixed>|null $bindingValues
     * @param array<string,mixed>|null $platform
     * @param list<UserReferenceErrors|array<string,mixed>>|null $userReferenceErrors
     * @param list<UserProfile|array<string,mixed>>|null $userReferences
     */
    public static function with(
        ?string $id = null,
        ?array $bindingValues = null,
        ?string $name = null,
        ?string $url = null,
        ?array $platform = null,
        ?array $userReferenceErrors = null,
        ?array $userReferences = null
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $bindingValues && $self['bindingValues'] = $bindingValues;
        null !== $name && $self['name'] = $name;
        null !== $url && $self['url'] = $url;

        null !== $platform && $self['platform'] = $platform;

        null !== $userReferenceErrors && $self['userReferenceErrors'] = $userReferenceErrors;

        null !== $userReferences && $self['userReferences'] = $userReferences;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param array<string,mixed> $bindingValues
     */
    public function withBindingValues(array $bindingValues): self
    {
        $self = clone $this;
        $self['bindingValues'] = $bindingValues;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Public metadata whose fields X defines.
     *
     * @param array<string,mixed>|null $platform
     */
    public function withPlatform(?array $platform): self
    {
        $self = clone $this;
        $self['platform'] = $platform;

        return $self;
    }

    /**
     * Unresolved card user references.
     *
     * @param list<UserReferenceErrors|array<string,mixed>>|null $userReferenceErrors
     */
    public function withUserReferenceErrors(?array $userReferenceErrors): self
    {
        $self = clone $this;
        $self['userReferenceErrors'] = $userReferenceErrors;

        return $self;
    }

    /**
     * @param list<UserProfile|array<string,mixed>>|null $userReferences
     */
    public function withUserReferences(?array $userReferences): self
    {
        $self = clone $this;
        $self['userReferences'] = $userReferences;

        return $self;
    }
}
