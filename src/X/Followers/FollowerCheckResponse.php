<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Followers;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type FollowerCheckResponseShape = array{
 *   isFollowedBy: bool,
 *   isFollowing: bool,
 *   sourceUsername: string,
 *   targetUsername: string,
 * }
 */
final class FollowerCheckResponse implements BaseModel
{
    /** @use SdkModel<FollowerCheckResponseShape> */
    use SdkModel;

    #[Required]
    public bool $isFollowedBy;

    #[Required]
    public bool $isFollowing;

    #[Required]
    public string $sourceUsername;

    #[Required]
    public string $targetUsername;

    /**
     * `new FollowerCheckResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FollowerCheckResponse::with(
     *   isFollowedBy: ..., isFollowing: ..., sourceUsername: ..., targetUsername: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FollowerCheckResponse)
     *   ->withIsFollowedBy(...)
     *   ->withIsFollowing(...)
     *   ->withSourceUsername(...)
     *   ->withTargetUsername(...)
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
        bool $isFollowedBy,
        bool $isFollowing,
        string $sourceUsername,
        string $targetUsername,
    ): self {
        $self = new self;

        $self['isFollowedBy'] = $isFollowedBy;
        $self['isFollowing'] = $isFollowing;
        $self['sourceUsername'] = $sourceUsername;
        $self['targetUsername'] = $targetUsername;

        return $self;
    }

    public function withIsFollowedBy(bool $isFollowedBy): self
    {
        $self = clone $this;
        $self['isFollowedBy'] = $isFollowedBy;

        return $self;
    }

    public function withIsFollowing(bool $isFollowing): self
    {
        $self = clone $this;
        $self['isFollowing'] = $isFollowing;

        return $self;
    }

    public function withSourceUsername(string $sourceUsername): self
    {
        $self = clone $this;
        $self['sourceUsername'] = $sourceUsername;

        return $self;
    }

    public function withTargetUsername(string $targetUsername): self
    {
        $self = clone $this;
        $self['targetUsername'] = $targetUsername;

        return $self;
    }
}
