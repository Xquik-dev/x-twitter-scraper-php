<?php

declare(strict_types=1);

namespace XTwitterScraper\X\WriteActions;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\WriteActions\WriteActionGetResponse\Media;
use XTwitterScraper\X\WriteActions\WriteActionGetResponse\Status;

/**
 * @phpstan-import-type MediaShape from \XTwitterScraper\X\WriteActions\WriteActionGetResponse\Media
 *
 * @phpstan-type WriteActionGetResponseShape = array{
 *   action: string,
 *   charged: bool,
 *   chargedCredits: string,
 *   createdAt: \DateTimeInterface,
 *   media: Media|MediaShape,
 *   retryable: bool,
 *   sendDispatched: bool,
 *   status: Status|value-of<Status>,
 *   writeActionID: string,
 *   confirmationAttempts?: int|null,
 *   confirmationCheckedAt?: \DateTimeInterface|null,
 *   confirmationSource?: string|null,
 *   confirmedAt?: \DateTimeInterface|null,
 *   message?: string|null,
 *   messageID?: string|null,
 *   sendDispatchedAt?: \DateTimeInterface|null,
 *   targetID?: string|null,
 *   tweetID?: string|null,
 * }
 */
final class WriteActionGetResponse implements BaseModel
{
    /** @use SdkModel<WriteActionGetResponseShape> */
    use SdkModel;

    #[Required]
    public bool $retryable = false;

    #[Required]
    public string $action;

    #[Required]
    public bool $charged;

    #[Required]
    public string $chargedCredits;

    #[Required]
    public \DateTimeInterface $createdAt;

    #[Required]
    public Media $media;

    #[Required]
    public bool $sendDispatched;

    /** @var value-of<Status> $status */
    #[Required(enum: Status::class)]
    public string $status;

    #[Required('writeActionId')]
    public string $writeActionID;

    #[Optional]
    public ?int $confirmationAttempts;

    #[Optional]
    public ?\DateTimeInterface $confirmationCheckedAt;

    #[Optional(nullable: true)]
    public ?string $confirmationSource;

    #[Optional]
    public ?\DateTimeInterface $confirmedAt;

    #[Optional]
    public ?string $message;

    #[Optional('messageId')]
    public ?string $messageID;

    #[Optional]
    public ?\DateTimeInterface $sendDispatchedAt;

    #[Optional('targetId', nullable: true)]
    public ?string $targetID;

    #[Optional('tweetId')]
    public ?string $tweetID;

    /**
     * `new WriteActionGetResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WriteActionGetResponse::with(
     *   action: ...,
     *   charged: ...,
     *   chargedCredits: ...,
     *   createdAt: ...,
     *   media: ...,
     *   sendDispatched: ...,
     *   status: ...,
     *   writeActionID: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WriteActionGetResponse)
     *   ->withAction(...)
     *   ->withCharged(...)
     *   ->withChargedCredits(...)
     *   ->withCreatedAt(...)
     *   ->withMedia(...)
     *   ->withSendDispatched(...)
     *   ->withStatus(...)
     *   ->withWriteActionID(...)
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
     * @param Media|MediaShape $media
     * @param Status|value-of<Status> $status
     */
    public static function with(
        string $action,
        bool $charged,
        string $chargedCredits,
        \DateTimeInterface $createdAt,
        Media|array $media,
        bool $sendDispatched,
        Status|string $status,
        string $writeActionID,
        ?int $confirmationAttempts = null,
        ?\DateTimeInterface $confirmationCheckedAt = null,
        ?string $confirmationSource = null,
        ?\DateTimeInterface $confirmedAt = null,
        ?string $message = null,
        ?string $messageID = null,
        ?\DateTimeInterface $sendDispatchedAt = null,
        ?string $targetID = null,
        ?string $tweetID = null,
    ): self {
        $self = new self;

        $self['action'] = $action;
        $self['charged'] = $charged;
        $self['chargedCredits'] = $chargedCredits;
        $self['createdAt'] = $createdAt;
        $self['media'] = $media;
        $self['sendDispatched'] = $sendDispatched;
        $self['status'] = $status;
        $self['writeActionID'] = $writeActionID;

        null !== $confirmationAttempts && $self['confirmationAttempts'] = $confirmationAttempts;
        null !== $confirmationCheckedAt && $self['confirmationCheckedAt'] = $confirmationCheckedAt;
        null !== $confirmationSource && $self['confirmationSource'] = $confirmationSource;
        null !== $confirmedAt && $self['confirmedAt'] = $confirmedAt;
        null !== $message && $self['message'] = $message;
        null !== $messageID && $self['messageID'] = $messageID;
        null !== $sendDispatchedAt && $self['sendDispatchedAt'] = $sendDispatchedAt;
        null !== $targetID && $self['targetID'] = $targetID;
        null !== $tweetID && $self['tweetID'] = $tweetID;

        return $self;
    }

    public function withAction(string $action): self
    {
        $self = clone $this;
        $self['action'] = $action;

        return $self;
    }

    public function withCharged(bool $charged): self
    {
        $self = clone $this;
        $self['charged'] = $charged;

        return $self;
    }

    public function withChargedCredits(string $chargedCredits): self
    {
        $self = clone $this;
        $self['chargedCredits'] = $chargedCredits;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * @param Media|MediaShape $media
     */
    public function withMedia(Media|array $media): self
    {
        $self = clone $this;
        $self['media'] = $media;

        return $self;
    }

    public function withRetryable(bool $retryable): self
    {
        $self = clone $this;
        $self['retryable'] = $retryable;

        return $self;
    }

    public function withSendDispatched(bool $sendDispatched): self
    {
        $self = clone $this;
        $self['sendDispatched'] = $sendDispatched;

        return $self;
    }

    /**
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withWriteActionID(string $writeActionID): self
    {
        $self = clone $this;
        $self['writeActionID'] = $writeActionID;

        return $self;
    }

    public function withConfirmationAttempts(int $confirmationAttempts): self
    {
        $self = clone $this;
        $self['confirmationAttempts'] = $confirmationAttempts;

        return $self;
    }

    public function withConfirmationCheckedAt(
        \DateTimeInterface $confirmationCheckedAt
    ): self {
        $self = clone $this;
        $self['confirmationCheckedAt'] = $confirmationCheckedAt;

        return $self;
    }

    public function withConfirmationSource(?string $confirmationSource): self
    {
        $self = clone $this;
        $self['confirmationSource'] = $confirmationSource;

        return $self;
    }

    public function withConfirmedAt(\DateTimeInterface $confirmedAt): self
    {
        $self = clone $this;
        $self['confirmedAt'] = $confirmedAt;

        return $self;
    }

    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }

    public function withMessageID(string $messageID): self
    {
        $self = clone $this;
        $self['messageID'] = $messageID;

        return $self;
    }

    public function withSendDispatchedAt(
        \DateTimeInterface $sendDispatchedAt
    ): self {
        $self = clone $this;
        $self['sendDispatchedAt'] = $sendDispatchedAt;

        return $self;
    }

    public function withTargetID(?string $targetID): self
    {
        $self = clone $this;
        $self['targetID'] = $targetID;

        return $self;
    }

    public function withTweetID(string $tweetID): self
    {
        $self = clone $this;
        $self['tweetID'] = $tweetID;

        return $self;
    }
}
