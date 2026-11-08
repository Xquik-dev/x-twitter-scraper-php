<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\SearchSuggestionUser\Badges;

/**
 * @phpstan-type SearchSuggestionUserShape = array{
 *   id: string,
 *   username: string,
 *   name: string,
 *   verified?: bool|null,
 *   isBlueVerified?: bool|null,
 *   isVerified?: bool|null,
 *   verifiedType?: string|null,
 *   protected?: bool|null,
 *   location?: string|null,
 *   profilePicture?: string|null,
 *   profilePictureOriginal?: string|null,
 *   badges?: list<Badges|array<string,mixed>>|null,
 *   isPersonaMediaGenable?: bool|null,
 *   score?: float|null,
 *   tokens?: list<string>|null,
 *   inline?: bool|null,
 * }
 */
final class SearchSuggestionUser implements BaseModel
{
    /** @use SdkModel<SearchSuggestionUserShape> */
    use SdkModel;

    /**
     * X user ID.
     */
    #[Required]
    public string $id;

    /**
     * Handle without the @.
     */
    #[Required]
    public string $username;

    /**
     * Display name.
     */
    #[Required]
    public string $name;

    /**
     * Whether X shows any verification badge.
     */
    #[Optional]
    public ?bool $verified;

    /**
     * Whether X shows a blue verification badge.
     */
    #[Optional]
    public ?bool $isBlueVerified;

    /**
     * Whether the account holds X's legacy verification.
     */
    #[Optional]
    public ?bool $isVerified;

    /**
     * Verification category, such as Government or Business. Omitted when X names none.
     */
    #[Optional]
    public ?string $verifiedType;

    /**
     * Whether the account protects its posts.
     */
    #[Optional]
    public ?bool $protected;

    /**
     * Public profile location text. Omitted when empty.
     */
    #[Optional]
    public ?string $location;

    /**
     * Avatar URL.
     */
    #[Optional]
    public ?string $profilePicture;

    /**
     * The same avatar at full size.
     */
    #[Optional]
    public ?string $profilePictureOriginal;

    /**
     * Affiliation badges X shows beside the name.
     *
     * @var list<Badges>|null $badges
     */
    #[Optional(list: Badges::class)]
    public ?array $badges;

    /**
     * X's flag for whether media can be generated from this account's persona.
     */
    #[Optional]
    public ?bool $isPersonaMediaGenable;

    /**
     * X's rounded relevance score for the account.
     */
    #[Optional]
    public ?float $score;

    /**
     * Normalized text tokens X matches the account by.
     *
     * @var list<string>|null $tokens
     */
    #[Optional(list: 'string')]
    public ?array $tokens;

    /**
     * X's inline flag for the account.
     */
    #[Optional]
    public ?bool $inline;

    /**
     * `new SearchSuggestionUser()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SearchSuggestionUser::with(id: ..., username: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SearchSuggestionUser)->withId(...)->withUsername(...)->withName(...)
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
     * @param list<Badges|array<string,mixed>>|null $badges
     * @param list<string>|null $tokens
     */
    public static function with(string $id, string $username, string $name, ?bool $verified = null, ?bool $isBlueVerified = null, ?bool $isVerified = null, ?string $verifiedType = null, ?bool $protected = null, ?string $location = null, ?string $profilePicture = null, ?string $profilePictureOriginal = null, ?array $badges = null, ?bool $isPersonaMediaGenable = null, ?float $score = null, ?array $tokens = null, ?bool $inline = null): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['username'] = $username;
        $self['name'] = $name;

        null !== $verified && $self['verified'] = $verified;
        null !== $isBlueVerified && $self['isBlueVerified'] = $isBlueVerified;
        null !== $isVerified && $self['isVerified'] = $isVerified;
        null !== $verifiedType && $self['verifiedType'] = $verifiedType;
        null !== $protected && $self['protected'] = $protected;
        null !== $location && $self['location'] = $location;
        null !== $profilePicture && $self['profilePicture'] = $profilePicture;
        null !== $profilePictureOriginal && $self['profilePictureOriginal'] = $profilePictureOriginal;
        null !== $badges && $self['badges'] = $badges;
        null !== $isPersonaMediaGenable && $self['isPersonaMediaGenable'] = $isPersonaMediaGenable;
        null !== $score && $self['score'] = $score;
        null !== $tokens && $self['tokens'] = $tokens;
        null !== $inline && $self['inline'] = $inline;

        return $self;
    }

    /**
     * X user ID.
     */
    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Handle without the @.
     */
    public function withUsername(string $username): self
    {
        $self = clone $this;
        $self['username'] = $username;

        return $self;
    }

    /**
     * Display name.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Whether X shows any verification badge.
     */
    public function withVerified(?bool $verified): self
    {
        $self = clone $this;
        $self['verified'] = $verified;

        return $self;
    }

    /**
     * Whether X shows a blue verification badge.
     */
    public function withIsBlueVerified(?bool $isBlueVerified): self
    {
        $self = clone $this;
        $self['isBlueVerified'] = $isBlueVerified;

        return $self;
    }

    /**
     * Whether the account holds X's legacy verification.
     */
    public function withIsVerified(?bool $isVerified): self
    {
        $self = clone $this;
        $self['isVerified'] = $isVerified;

        return $self;
    }

    /**
     * Verification category, such as Government or Business. Omitted when X names none.
     */
    public function withVerifiedType(?string $verifiedType): self
    {
        $self = clone $this;
        $self['verifiedType'] = $verifiedType;

        return $self;
    }

    /**
     * Whether the account protects its posts.
     */
    public function withProtected(?bool $protected): self
    {
        $self = clone $this;
        $self['protected'] = $protected;

        return $self;
    }

    /**
     * Public profile location text. Omitted when empty.
     */
    public function withLocation(?string $location): self
    {
        $self = clone $this;
        $self['location'] = $location;

        return $self;
    }

    /**
     * Avatar URL.
     */
    public function withProfilePicture(?string $profilePicture): self
    {
        $self = clone $this;
        $self['profilePicture'] = $profilePicture;

        return $self;
    }

    /**
     * The same avatar at full size.
     */
    public function withProfilePictureOriginal(?string $profilePictureOriginal): self
    {
        $self = clone $this;
        $self['profilePictureOriginal'] = $profilePictureOriginal;

        return $self;
    }

    /**
     * Affiliation badges X shows beside the name.
     *
     * @param list<Badges|array<string,mixed>>|null $badges
     */
    public function withBadges(?array $badges): self
    {
        $self = clone $this;
        $self['badges'] = $badges;

        return $self;
    }

    /**
     * X's flag for whether media can be generated from this account's persona.
     */
    public function withIsPersonaMediaGenable(?bool $isPersonaMediaGenable): self
    {
        $self = clone $this;
        $self['isPersonaMediaGenable'] = $isPersonaMediaGenable;

        return $self;
    }

    /**
     * X's rounded relevance score for the account.
     */
    public function withScore(?float $score): self
    {
        $self = clone $this;
        $self['score'] = $score;

        return $self;
    }

    /**
     * Normalized text tokens X matches the account by.
     *
     * @param list<string>|null $tokens
     */
    public function withTokens(?array $tokens): self
    {
        $self = clone $this;
        $self['tokens'] = $tokens;

        return $self;
    }

    /**
     * X's inline flag for the account.
     */
    public function withInline(?bool $inline): self
    {
        $self = clone $this;
        $self['inline'] = $inline;

        return $self;
    }
}
