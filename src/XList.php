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

/**
 * @phpstan-type XListShape = array{
 *   id: string,
 *   name: string,
 *   description?: string|null,
 *   memberCount?: int|null,
 *   subscriberCount?: int|null,
 *   owner?: UserProfile|array<string,mixed>|null,
 *   url?: string|null,
 *   createdAt?: \DateTimeInterface|null,
 *   bannerUrl?: string|null,
 *   customBanner?: XListBanner|array<string,mixed>|null,
 *   defaultBanner?: XListBanner|array<string,mixed>|null,
 *   facepileUrls?: list<string>|null,
 *   membersContext?: string|null,
 * }
 */
final class XList implements BaseModel
{
    /** @use SdkModel<XListShape> */
    use SdkModel;

    /**
     * Numeric ID of the List.
     */
    #[Required]
    public string $id;

    /**
     * Name the owner gave the List.
     */
    #[Required]
    public string $name;

    /**
     * About text of the List. Empty when the owner wrote none.
     */
    #[Optional]
    public ?string $description;

    /**
     * Accounts on the List.
     */
    #[Optional]
    public ?int $memberCount;

    /**
     * Accounts that follow the List, which X calls followers.
     */
    #[Optional]
    public ?int $subscriberCount;

    /**
     * Public profile of the account that owns the List.
     */
    #[Optional]
    public ?UserProfile $owner;

    /**
     * List page on x.com.
     */
    #[Optional]
    public ?string $url;

    /**
     * When the owner made the List.
     */
    #[Optional]
    public ?\DateTimeInterface $createdAt;

    /**
     * URL of the banner the owner uploaded. Absent when the owner uploaded none.
     */
    #[Optional]
    public ?string $bannerUrl;

    /**
     * Banner the owner uploaded.
     */
    #[Optional]
    public ?XListBanner $customBanner;

    /**
     * Banner X shows when the owner uploaded none. It can differ between calls.
     */
    #[Optional]
    public ?XListBanner $defaultBanner;

    /**
     * Avatar URLs of a few List members, which X may pick per request.
     *
     * @var list<string>|null $facepileUrls
     */
    #[Optional(list: 'string')]
    public ?array $facepileUrls;

    /**
     * Member count as X words it, such as 35 members.
     */
    #[Optional]
    public ?string $membersContext;

    /**
     * `new XList()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * XList::with(id: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new XList)->withId(...)->withName(...)
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
     * @param UserProfile|array<string,mixed>|null $owner
     * @param XListBanner|array<string,mixed>|null $customBanner
     * @param XListBanner|array<string,mixed>|null $defaultBanner
     * @param list<string>|null $facepileUrls
     */
    public static function with(string $id, string $name, ?string $description = null, ?int $memberCount = null, ?int $subscriberCount = null, UserProfile|array|null $owner = null, ?string $url = null, ?\DateTimeInterface $createdAt = null, ?string $bannerUrl = null, XListBanner|array|null $customBanner = null, XListBanner|array|null $defaultBanner = null, ?array $facepileUrls = null, ?string $membersContext = null): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['name'] = $name;

        null !== $description && $self['description'] = $description;
        null !== $memberCount && $self['memberCount'] = $memberCount;
        null !== $subscriberCount && $self['subscriberCount'] = $subscriberCount;
        null !== $owner && $self['owner'] = $owner;
        null !== $url && $self['url'] = $url;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $bannerUrl && $self['bannerUrl'] = $bannerUrl;
        null !== $customBanner && $self['customBanner'] = $customBanner;
        null !== $defaultBanner && $self['defaultBanner'] = $defaultBanner;
        null !== $facepileUrls && $self['facepileUrls'] = $facepileUrls;
        null !== $membersContext && $self['membersContext'] = $membersContext;

        return $self;
    }

    /**
     * Numeric ID of the List.
     */
    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Name the owner gave the List.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * About text of the List. Empty when the owner wrote none.
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Accounts on the List.
     */
    public function withMemberCount(?int $memberCount): self
    {
        $self = clone $this;
        $self['memberCount'] = $memberCount;

        return $self;
    }

    /**
     * Accounts that follow the List, which X calls followers.
     */
    public function withSubscriberCount(?int $subscriberCount): self
    {
        $self = clone $this;
        $self['subscriberCount'] = $subscriberCount;

        return $self;
    }

    /**
     * Public profile of the account that owns the List.
     *
     * @param UserProfile|array<string,mixed>|null $owner
     */
    public function withOwner(UserProfile|array|null $owner): self
    {
        $self = clone $this;
        $self['owner'] = $owner;

        return $self;
    }

    /**
     * List page on x.com.
     */
    public function withUrl(?string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * When the owner made the List.
     */
    public function withCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * URL of the banner the owner uploaded. Absent when the owner uploaded none.
     */
    public function withBannerUrl(?string $bannerUrl): self
    {
        $self = clone $this;
        $self['bannerUrl'] = $bannerUrl;

        return $self;
    }

    /**
     * Banner the owner uploaded.
     *
     * @param XListBanner|array<string,mixed>|null $customBanner
     */
    public function withCustomBanner(XListBanner|array|null $customBanner): self
    {
        $self = clone $this;
        $self['customBanner'] = $customBanner;

        return $self;
    }

    /**
     * Banner X shows when the owner uploaded none. It can differ between calls.
     *
     * @param XListBanner|array<string,mixed>|null $defaultBanner
     */
    public function withDefaultBanner(XListBanner|array|null $defaultBanner): self
    {
        $self = clone $this;
        $self['defaultBanner'] = $defaultBanner;

        return $self;
    }

    /**
     * Avatar URLs of a few List members, which X may pick per request.
     *
     * @param list<string>|null $facepileUrls
     */
    public function withFacepileUrls(?array $facepileUrls): self
    {
        $self = clone $this;
        $self['facepileUrls'] = $facepileUrls;

        return $self;
    }

    /**
     * Member count as X words it, such as 35 members.
     */
    public function withMembersContext(?string $membersContext): self
    {
        $self = clone $this;
        $self['membersContext'] = $membersContext;

        return $self;
    }
}
