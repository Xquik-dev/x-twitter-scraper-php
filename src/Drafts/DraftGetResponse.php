<?php

declare(strict_types=1);

namespace XTwitterScraper\Drafts;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type DraftGetResponseShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   text: string,
 *   updatedAt: \DateTimeInterface,
 *   goal?: string|null,
 *   topic?: string|null,
 * }
 */
final class DraftGetResponse implements BaseModel
{
    /** @use SdkModel<DraftGetResponseShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public \DateTimeInterface $createdAt;

    #[Required]
    public string $text;

    #[Required]
    public \DateTimeInterface $updatedAt;

    #[Optional]
    public ?string $goal;

    #[Optional]
    public ?string $topic;

    /**
     * `new DraftGetResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DraftGetResponse::with(id: ..., createdAt: ..., text: ..., updatedAt: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DraftGetResponse)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withText(...)
     *   ->withUpdatedAt(...)
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
        \DateTimeInterface $createdAt,
        string $text,
        \DateTimeInterface $updatedAt,
        ?string $goal = null,
        ?string $topic = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['text'] = $text;
        $self['updatedAt'] = $updatedAt;

        null !== $goal && $self['goal'] = $goal;
        null !== $topic && $self['topic'] = $topic;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    public function withGoal(string $goal): self
    {
        $self = clone $this;
        $self['goal'] = $goal;

        return $self;
    }

    public function withTopic(string $topic): self
    {
        $self = clone $this;
        $self['topic'] = $topic;

        return $self;
    }
}
