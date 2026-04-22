<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Communities\CommunityGetInfoResponse;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Communities\CommunityGetInfoResponse\Community\PrimaryTopic;
use XTwitterScraper\X\Communities\CommunityGetInfoResponse\Community\Rule;

/**
 * Community info object.
 *
 * @phpstan-import-type PrimaryTopicShape from \XTwitterScraper\X\Communities\CommunityGetInfoResponse\Community\PrimaryTopic
 * @phpstan-import-type RuleShape from \XTwitterScraper\X\Communities\CommunityGetInfoResponse\Community\Rule
 *
 * @phpstan-type CommunityShape = array{
 *   id: string,
 *   bannerURL?: string|null,
 *   createdAt?: string|null,
 *   description?: string|null,
 *   joinPolicy?: string|null,
 *   memberCount?: int|null,
 *   moderatorCount?: int|null,
 *   name?: string|null,
 *   primaryTopic?: null|PrimaryTopic|PrimaryTopicShape,
 *   rules?: list<Rule|RuleShape>|null,
 * }
 */
final class Community implements BaseModel
{
    /** @use SdkModel<CommunityShape> */
    use SdkModel;

    /**
     * Unique community identifier.
     */
    #[Required]
    public string $id;

    /**
     * Community banner image URL.
     */
    #[Optional('banner_url')]
    public ?string $bannerURL;

    /**
     * Community creation timestamp.
     */
    #[Optional('created_at')]
    public ?string $createdAt;

    /**
     * About text for the community.
     */
    #[Optional]
    public ?string $description;

    /**
     * Join policy (open or restricted).
     */
    #[Optional('join_policy')]
    public ?string $joinPolicy;

    /**
     * Total member count.
     */
    #[Optional('member_count')]
    public ?int $memberCount;

    /**
     * Total moderator count.
     */
    #[Optional('moderator_count')]
    public ?int $moderatorCount;

    /**
     * Display name of the community.
     */
    #[Optional]
    public ?string $name;

    /**
     * Primary topic.
     */
    #[Optional('primary_topic')]
    public ?PrimaryTopic $primaryTopic;

    /**
     * Community rules.
     *
     * @var list<Rule>|null $rules
     */
    #[Optional(list: Rule::class)]
    public ?array $rules;

    /**
     * `new Community()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Community::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Community)->withID(...)
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
     * @param PrimaryTopic|PrimaryTopicShape|null $primaryTopic
     * @param list<Rule|RuleShape>|null $rules
     */
    public static function with(
        string $id,
        ?string $bannerURL = null,
        ?string $createdAt = null,
        ?string $description = null,
        ?string $joinPolicy = null,
        ?int $memberCount = null,
        ?int $moderatorCount = null,
        ?string $name = null,
        PrimaryTopic|array|null $primaryTopic = null,
        ?array $rules = null,
    ): self {
        $self = new self;

        $self['id'] = $id;

        null !== $bannerURL && $self['bannerURL'] = $bannerURL;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $description && $self['description'] = $description;
        null !== $joinPolicy && $self['joinPolicy'] = $joinPolicy;
        null !== $memberCount && $self['memberCount'] = $memberCount;
        null !== $moderatorCount && $self['moderatorCount'] = $moderatorCount;
        null !== $name && $self['name'] = $name;
        null !== $primaryTopic && $self['primaryTopic'] = $primaryTopic;
        null !== $rules && $self['rules'] = $rules;

        return $self;
    }

    /**
     * Unique community identifier.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Community banner image URL.
     */
    public function withBannerURL(string $bannerURL): self
    {
        $self = clone $this;
        $self['bannerURL'] = $bannerURL;

        return $self;
    }

    /**
     * Community creation timestamp.
     */
    public function withCreatedAt(string $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * About text for the community.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Join policy (open or restricted).
     */
    public function withJoinPolicy(string $joinPolicy): self
    {
        $self = clone $this;
        $self['joinPolicy'] = $joinPolicy;

        return $self;
    }

    /**
     * Total member count.
     */
    public function withMemberCount(int $memberCount): self
    {
        $self = clone $this;
        $self['memberCount'] = $memberCount;

        return $self;
    }

    /**
     * Total moderator count.
     */
    public function withModeratorCount(int $moderatorCount): self
    {
        $self = clone $this;
        $self['moderatorCount'] = $moderatorCount;

        return $self;
    }

    /**
     * Display name of the community.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Primary topic.
     *
     * @param PrimaryTopic|PrimaryTopicShape $primaryTopic
     */
    public function withPrimaryTopic(PrimaryTopic|array $primaryTopic): self
    {
        $self = clone $this;
        $self['primaryTopic'] = $primaryTopic;

        return $self;
    }

    /**
     * Community rules.
     *
     * @param list<Rule|RuleShape> $rules
     */
    public function withRules(array $rules): self
    {
        $self = clone $this;
        $self['rules'] = $rules;

        return $self;
    }
}
