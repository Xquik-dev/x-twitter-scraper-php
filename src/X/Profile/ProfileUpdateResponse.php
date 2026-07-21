<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Profile;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Profile\ProfileUpdateResponse\Account;
use XTwitterScraper\X\Profile\ProfileUpdateResponse\Action;
use XTwitterScraper\X\Profile\ProfileUpdateResponse\Billing;
use XTwitterScraper\X\Profile\ProfileUpdateResponse\NextAction;
use XTwitterScraper\X\Profile\ProfileUpdateResponse\Request;
use XTwitterScraper\X\Profile\ProfileUpdateResponse\Result;
use XTwitterScraper\X\Profile\ProfileUpdateResponse\Status;
use XTwitterScraper\X\Profile\ProfileUpdateResponse\Target;

/**
 * Durable write lifecycle record. Poll statusUrl until terminal is true. Reusing the original Idempotency-Key returns this same record. Submit a new write only when safeToRetry is true, using a new key.
 *
 * @phpstan-import-type AccountShape from \XTwitterScraper\X\Profile\ProfileUpdateResponse\Account
 * @phpstan-import-type BillingShape from \XTwitterScraper\X\Profile\ProfileUpdateResponse\Billing
 * @phpstan-import-type NextActionShape from \XTwitterScraper\X\Profile\ProfileUpdateResponse\NextAction
 * @phpstan-import-type RequestShape from \XTwitterScraper\X\Profile\ProfileUpdateResponse\Request
 * @phpstan-import-type ResultShape from \XTwitterScraper\X\Profile\ProfileUpdateResponse\Result
 * @phpstan-import-type TargetShape from \XTwitterScraper\X\Profile\ProfileUpdateResponse\Target
 *
 * @phpstan-type ProfileUpdateResponseShape = array{
 *   id: string,
 *   account: null|Account|AccountShape,
 *   action: Action|value-of<Action>,
 *   billing: Billing|BillingShape,
 *   charged: bool,
 *   chargedCredits: string,
 *   nextAction: null|NextAction|NextActionShape,
 *   object: 'x_write_action',
 *   pollAfterMs: int|null,
 *   request: Request|RequestShape,
 *   result: null|Result|ResultShape,
 *   retryable: bool,
 *   safeToRetry: bool,
 *   sendDispatched: bool,
 *   status: Status|value-of<Status>,
 *   statusURL: string,
 *   success: bool,
 *   target: null|Target|TargetShape,
 *   targetID: string|null,
 *   terminal: bool,
 *   writeActionID: string,
 *   communityID?: string|null,
 *   communityName?: string|null,
 *   completedAt?: \DateTimeInterface|null,
 *   confirmationAttempts?: int|null,
 *   confirmationCheckedAt?: \DateTimeInterface|null,
 *   confirmedAt?: \DateTimeInterface|null,
 *   createdAt?: \DateTimeInterface|null,
 *   details?: array<string,mixed>|null,
 *   error?: string|null,
 *   expiresAt?: \DateTimeInterface|null,
 *   idempotent?: bool|null,
 *   media?: array<string,mixed>|null,
 *   mediaID?: string|null,
 *   mediaURL?: string|null,
 *   message?: string|null,
 *   messageID?: string|null,
 *   requestHash?: string|null,
 *   requestID?: string|null,
 *   resultID?: string|null,
 *   sendDispatchedAt?: \DateTimeInterface|null,
 *   tweetID?: string|null,
 *   updatedAt?: \DateTimeInterface|null,
 * }
 */
final class ProfileUpdateResponse implements BaseModel
{
    /** @use SdkModel<ProfileUpdateResponseShape> */
    use SdkModel;

    /** @var 'x_write_action' $object */
    #[Required]
    public string $object = 'x_write_action';

    #[Required]
    public string $id;

    /**
     * Connected account selected for the write.
     */
    #[Required]
    public ?Account $account;

    /** @var value-of<Action> $action */
    #[Required(enum: Action::class)]
    public string $action;

    /**
     * plannedCredits is the approved maximum. chargedCredits comes from the settled credit ledger. Pending or failed writes are not charged.
     */
    #[Required]
    public Billing $billing;

    #[Required]
    public bool $charged;

    #[Required]
    public string $chargedCredits;

    /**
     * Exact follow-up an API client or agent should perform.
     */
    #[Required]
    public ?NextAction $nextAction;

    #[Required]
    public ?int $pollAfterMs;

    /**
     * Stable fingerprint and sanitized payload for replay checks.
     */
    #[Required]
    public Request $request;

    /**
     * Confirmed result produced by the write, when available.
     */
    #[Required]
    public ?Result $result;

    /**
     * True only when a new attempt can reasonably succeed.
     */
    #[Required]
    public bool $retryable;

    /**
     * True only when no write was dispatched and a new idempotency key may be used.
     */
    #[Required]
    public bool $safeToRetry;

    #[Required]
    public bool $sendDispatched;

    /** @var value-of<Status> $status */
    #[Required(enum: Status::class)]
    public string $status;

    #[Required('statusUrl')]
    public string $statusURL;

    #[Required]
    public bool $success;

    /**
     * Existing X resource targeted by the write, when applicable.
     */
    #[Required]
    public ?Target $target;

    #[Required('targetId')]
    public ?string $targetID;

    #[Required]
    public bool $terminal;

    #[Required('writeActionId')]
    public string $writeActionID;

    /**
     * Compatibility field for a confirmed community ID.
     */
    #[Optional('communityId')]
    public ?string $communityID;

    /**
     * Confirmed community name when available.
     */
    #[Optional]
    public ?string $communityName;

    #[Optional]
    public ?\DateTimeInterface $completedAt;

    #[Optional]
    public ?int $confirmationAttempts;

    #[Optional]
    public ?\DateTimeInterface $confirmationCheckedAt;

    #[Optional]
    public ?\DateTimeInterface $confirmedAt;

    #[Optional]
    public ?\DateTimeInterface $createdAt;

    /**
     * Structured recovery context for a failed write.
     *
     * @var array<string,mixed>|null $details
     */
    #[Optional(map: 'mixed')]
    public ?array $details;

    #[Optional]
    public ?string $error;

    /**
     * Deadline for resolving a non-terminal write. This is not the Idempotency-Key retention deadline.
     */
    #[Optional]
    public ?\DateTimeInterface $expiresAt;

    #[Optional]
    public ?bool $idempotent;

    /**
     * Media count, kind, size, and billing details when used.
     *
     * @var array<string,mixed>|null $media
     */
    #[Optional(map: 'mixed')]
    public ?array $media;

    /**
     * Compatibility field for a confirmed media upload ID.
     */
    #[Optional('mediaId')]
    public ?string $mediaID;

    /**
     * Public media URL when the upload creates one.
     */
    #[Optional('mediaUrl')]
    public ?string $mediaURL;

    #[Optional]
    public ?string $message;

    /**
     * Compatibility field for a confirmed direct message ID.
     */
    #[Optional('messageId')]
    public ?string $messageID;

    #[Optional]
    public ?string $requestHash;

    #[Optional('requestId')]
    public ?string $requestID;

    /**
     * Compatibility result ID for other write actions.
     */
    #[Optional('resultId')]
    public ?string $resultID;

    /**
     * Dispatch timestamp when the write reached execution.
     */
    #[Optional]
    public ?\DateTimeInterface $sendDispatchedAt;

    /**
     * Compatibility field for a confirmed tweet result ID.
     */
    #[Optional('tweetId')]
    public ?string $tweetID;

    #[Optional]
    public ?\DateTimeInterface $updatedAt;

    /**
     * `new ProfileUpdateResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ProfileUpdateResponse::with(
     *   id: ...,
     *   account: ...,
     *   action: ...,
     *   billing: ...,
     *   charged: ...,
     *   chargedCredits: ...,
     *   nextAction: ...,
     *   pollAfterMs: ...,
     *   request: ...,
     *   result: ...,
     *   retryable: ...,
     *   safeToRetry: ...,
     *   sendDispatched: ...,
     *   status: ...,
     *   statusURL: ...,
     *   success: ...,
     *   target: ...,
     *   targetID: ...,
     *   terminal: ...,
     *   writeActionID: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ProfileUpdateResponse)
     *   ->withID(...)
     *   ->withAccount(...)
     *   ->withAction(...)
     *   ->withBilling(...)
     *   ->withCharged(...)
     *   ->withChargedCredits(...)
     *   ->withNextAction(...)
     *   ->withPollAfterMs(...)
     *   ->withRequest(...)
     *   ->withResult(...)
     *   ->withRetryable(...)
     *   ->withSafeToRetry(...)
     *   ->withSendDispatched(...)
     *   ->withStatus(...)
     *   ->withStatusURL(...)
     *   ->withSuccess(...)
     *   ->withTarget(...)
     *   ->withTargetID(...)
     *   ->withTerminal(...)
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
     * @param Account|AccountShape|null $account
     * @param Action|value-of<Action> $action
     * @param Billing|BillingShape $billing
     * @param NextAction|NextActionShape|null $nextAction
     * @param Request|RequestShape $request
     * @param Result|ResultShape|null $result
     * @param Status|value-of<Status> $status
     * @param Target|TargetShape|null $target
     * @param array<string,mixed>|null $details
     * @param array<string,mixed>|null $media
     */
    public static function with(
        string $id,
        Account|array|null $account,
        Action|string $action,
        Billing|array $billing,
        bool $charged,
        string $chargedCredits,
        NextAction|array|null $nextAction,
        ?int $pollAfterMs,
        Request|array $request,
        Result|array|null $result,
        bool $retryable,
        bool $safeToRetry,
        bool $sendDispatched,
        Status|string $status,
        string $statusURL,
        bool $success,
        Target|array|null $target,
        ?string $targetID,
        bool $terminal,
        string $writeActionID,
        ?string $communityID = null,
        ?string $communityName = null,
        ?\DateTimeInterface $completedAt = null,
        ?int $confirmationAttempts = null,
        ?\DateTimeInterface $confirmationCheckedAt = null,
        ?\DateTimeInterface $confirmedAt = null,
        ?\DateTimeInterface $createdAt = null,
        ?array $details = null,
        ?string $error = null,
        ?\DateTimeInterface $expiresAt = null,
        ?bool $idempotent = null,
        ?array $media = null,
        ?string $mediaID = null,
        ?string $mediaURL = null,
        ?string $message = null,
        ?string $messageID = null,
        ?string $requestHash = null,
        ?string $requestID = null,
        ?string $resultID = null,
        ?\DateTimeInterface $sendDispatchedAt = null,
        ?string $tweetID = null,
        ?\DateTimeInterface $updatedAt = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['account'] = $account;
        $self['action'] = $action;
        $self['billing'] = $billing;
        $self['charged'] = $charged;
        $self['chargedCredits'] = $chargedCredits;
        $self['nextAction'] = $nextAction;
        $self['pollAfterMs'] = $pollAfterMs;
        $self['request'] = $request;
        $self['result'] = $result;
        $self['retryable'] = $retryable;
        $self['safeToRetry'] = $safeToRetry;
        $self['sendDispatched'] = $sendDispatched;
        $self['status'] = $status;
        $self['statusURL'] = $statusURL;
        $self['success'] = $success;
        $self['target'] = $target;
        $self['targetID'] = $targetID;
        $self['terminal'] = $terminal;
        $self['writeActionID'] = $writeActionID;

        null !== $communityID && $self['communityID'] = $communityID;
        null !== $communityName && $self['communityName'] = $communityName;
        null !== $completedAt && $self['completedAt'] = $completedAt;
        null !== $confirmationAttempts && $self['confirmationAttempts'] = $confirmationAttempts;
        null !== $confirmationCheckedAt && $self['confirmationCheckedAt'] = $confirmationCheckedAt;
        null !== $confirmedAt && $self['confirmedAt'] = $confirmedAt;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $details && $self['details'] = $details;
        null !== $error && $self['error'] = $error;
        null !== $expiresAt && $self['expiresAt'] = $expiresAt;
        null !== $idempotent && $self['idempotent'] = $idempotent;
        null !== $media && $self['media'] = $media;
        null !== $mediaID && $self['mediaID'] = $mediaID;
        null !== $mediaURL && $self['mediaURL'] = $mediaURL;
        null !== $message && $self['message'] = $message;
        null !== $messageID && $self['messageID'] = $messageID;
        null !== $requestHash && $self['requestHash'] = $requestHash;
        null !== $requestID && $self['requestID'] = $requestID;
        null !== $resultID && $self['resultID'] = $resultID;
        null !== $sendDispatchedAt && $self['sendDispatchedAt'] = $sendDispatchedAt;
        null !== $tweetID && $self['tweetID'] = $tweetID;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Connected account selected for the write.
     *
     * @param Account|AccountShape|null $account
     */
    public function withAccount(Account|array|null $account): self
    {
        $self = clone $this;
        $self['account'] = $account;

        return $self;
    }

    /**
     * @param Action|value-of<Action> $action
     */
    public function withAction(Action|string $action): self
    {
        $self = clone $this;
        $self['action'] = $action;

        return $self;
    }

    /**
     * plannedCredits is the approved maximum. chargedCredits comes from the settled credit ledger. Pending or failed writes are not charged.
     *
     * @param Billing|BillingShape $billing
     */
    public function withBilling(Billing|array $billing): self
    {
        $self = clone $this;
        $self['billing'] = $billing;

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

    /**
     * Exact follow-up an API client or agent should perform.
     *
     * @param NextAction|NextActionShape|null $nextAction
     */
    public function withNextAction(NextAction|array|null $nextAction): self
    {
        $self = clone $this;
        $self['nextAction'] = $nextAction;

        return $self;
    }

    /**
     * @param 'x_write_action' $object
     */
    public function withObject(string $object): self
    {
        $self = clone $this;
        $self['object'] = $object;

        return $self;
    }

    public function withPollAfterMs(?int $pollAfterMs): self
    {
        $self = clone $this;
        $self['pollAfterMs'] = $pollAfterMs;

        return $self;
    }

    /**
     * Stable fingerprint and sanitized payload for replay checks.
     *
     * @param Request|RequestShape $request
     */
    public function withRequest(Request|array $request): self
    {
        $self = clone $this;
        $self['request'] = $request;

        return $self;
    }

    /**
     * Confirmed result produced by the write, when available.
     *
     * @param Result|ResultShape|null $result
     */
    public function withResult(Result|array|null $result): self
    {
        $self = clone $this;
        $self['result'] = $result;

        return $self;
    }

    /**
     * True only when a new attempt can reasonably succeed.
     */
    public function withRetryable(bool $retryable): self
    {
        $self = clone $this;
        $self['retryable'] = $retryable;

        return $self;
    }

    /**
     * True only when no write was dispatched and a new idempotency key may be used.
     */
    public function withSafeToRetry(bool $safeToRetry): self
    {
        $self = clone $this;
        $self['safeToRetry'] = $safeToRetry;

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

    public function withStatusURL(string $statusURL): self
    {
        $self = clone $this;
        $self['statusURL'] = $statusURL;

        return $self;
    }

    public function withSuccess(bool $success): self
    {
        $self = clone $this;
        $self['success'] = $success;

        return $self;
    }

    /**
     * Existing X resource targeted by the write, when applicable.
     *
     * @param Target|TargetShape|null $target
     */
    public function withTarget(Target|array|null $target): self
    {
        $self = clone $this;
        $self['target'] = $target;

        return $self;
    }

    public function withTargetID(?string $targetID): self
    {
        $self = clone $this;
        $self['targetID'] = $targetID;

        return $self;
    }

    public function withTerminal(bool $terminal): self
    {
        $self = clone $this;
        $self['terminal'] = $terminal;

        return $self;
    }

    public function withWriteActionID(string $writeActionID): self
    {
        $self = clone $this;
        $self['writeActionID'] = $writeActionID;

        return $self;
    }

    /**
     * Compatibility field for a confirmed community ID.
     */
    public function withCommunityID(string $communityID): self
    {
        $self = clone $this;
        $self['communityID'] = $communityID;

        return $self;
    }

    /**
     * Confirmed community name when available.
     */
    public function withCommunityName(string $communityName): self
    {
        $self = clone $this;
        $self['communityName'] = $communityName;

        return $self;
    }

    public function withCompletedAt(\DateTimeInterface $completedAt): self
    {
        $self = clone $this;
        $self['completedAt'] = $completedAt;

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

    public function withConfirmedAt(\DateTimeInterface $confirmedAt): self
    {
        $self = clone $this;
        $self['confirmedAt'] = $confirmedAt;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Structured recovery context for a failed write.
     *
     * @param array<string,mixed> $details
     */
    public function withDetails(array $details): self
    {
        $self = clone $this;
        $self['details'] = $details;

        return $self;
    }

    public function withError(string $error): self
    {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }

    /**
     * Deadline for resolving a non-terminal write. This is not the Idempotency-Key retention deadline.
     */
    public function withExpiresAt(\DateTimeInterface $expiresAt): self
    {
        $self = clone $this;
        $self['expiresAt'] = $expiresAt;

        return $self;
    }

    public function withIdempotent(bool $idempotent): self
    {
        $self = clone $this;
        $self['idempotent'] = $idempotent;

        return $self;
    }

    /**
     * Media count, kind, size, and billing details when used.
     *
     * @param array<string,mixed> $media
     */
    public function withMedia(array $media): self
    {
        $self = clone $this;
        $self['media'] = $media;

        return $self;
    }

    /**
     * Compatibility field for a confirmed media upload ID.
     */
    public function withMediaID(string $mediaID): self
    {
        $self = clone $this;
        $self['mediaID'] = $mediaID;

        return $self;
    }

    /**
     * Public media URL when the upload creates one.
     */
    public function withMediaURL(string $mediaURL): self
    {
        $self = clone $this;
        $self['mediaURL'] = $mediaURL;

        return $self;
    }

    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }

    /**
     * Compatibility field for a confirmed direct message ID.
     */
    public function withMessageID(string $messageID): self
    {
        $self = clone $this;
        $self['messageID'] = $messageID;

        return $self;
    }

    public function withRequestHash(string $requestHash): self
    {
        $self = clone $this;
        $self['requestHash'] = $requestHash;

        return $self;
    }

    public function withRequestID(string $requestID): self
    {
        $self = clone $this;
        $self['requestID'] = $requestID;

        return $self;
    }

    /**
     * Compatibility result ID for other write actions.
     */
    public function withResultID(string $resultID): self
    {
        $self = clone $this;
        $self['resultID'] = $resultID;

        return $self;
    }

    /**
     * Dispatch timestamp when the write reached execution.
     */
    public function withSendDispatchedAt(
        \DateTimeInterface $sendDispatchedAt
    ): self {
        $self = clone $this;
        $self['sendDispatchedAt'] = $sendDispatchedAt;

        return $self;
    }

    /**
     * Compatibility field for a confirmed tweet result ID.
     */
    public function withTweetID(string $tweetID): self
    {
        $self = clone $this;
        $self['tweetID'] = $tweetID;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
