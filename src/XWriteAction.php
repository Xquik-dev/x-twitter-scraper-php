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
use XTwitterScraper\XWriteAction\Action;
use XTwitterScraper\XWriteAction\ObjectModel;
use XTwitterScraper\XWriteAction\Status;

/**
 * @phpstan-type XWriteActionShape = array{
 *   object: ObjectModel|value-of<ObjectModel>,
 *   id: string,
 *   writeActionID: string,
 *   action: Action|value-of<Action>,
 *   status: Status|value-of<Status>,
 *   terminal: bool,
 *   retryable: bool,
 *   safeToRetry: bool,
 *   statusUrl: string,
 *   pollAfterMs: int|null,
 *   charged: bool,
 *   chargedCredits: string,
 *   billing: XWriteActionBilling|array<string,mixed>,
 *   request: XWriteActionRequest|array<string,mixed>,
 *   account: XWriteActionAccount|array<string,mixed>|null,
 *   target: XWriteActionTarget|array<string,mixed>|null,
 *   targetID: string|null,
 *   result: XWriteActionResult|array<string,mixed>|null,
 *   nextAction: XWriteActionNextAction|array<string,mixed>|null,
 *   sendDispatched: bool,
 *   success: bool,
 *   requestHash?: string|null,
 *   requestID?: string|null,
 *   idempotent?: bool|null,
 *   error?: string|null,
 *   message?: string|null,
 *   sendDispatchedAt?: \DateTimeInterface|null,
 *   createdAt?: \DateTimeInterface|null,
 *   updatedAt?: \DateTimeInterface|null,
 *   completedAt?: \DateTimeInterface|null,
 *   expiresAt?: \DateTimeInterface|null,
 *   confirmedAt?: \DateTimeInterface|null,
 *   confirmationCheckedAt?: \DateTimeInterface|null,
 *   confirmationAttempts?: int|null,
 *   tweetID?: string|null,
 *   messageID?: string|null,
 *   mediaID?: string|null,
 *   mediaUrl?: string|null,
 *   communityID?: string|null,
 *   communityName?: string|null,
 *   resultID?: string|null,
 *   media?: array<string,mixed>|null,
 *   details?: array<string,mixed>|null,
 * }
 */
final class XWriteAction implements BaseModel
{
    /** @use SdkModel<XWriteActionShape> */
    use SdkModel;

    /**
     * @var value-of<ObjectModel> $object
     */
    #[Required(enum: ObjectModel::class)]
    public string $object;

    #[Required]
    public string $id;

    #[Required('writeActionId')]
    public string $writeActionID;

    /**
     * @var value-of<Action> $action
     */
    #[Required(enum: Action::class)]
    public string $action;

    /**
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    #[Required]
    public bool $terminal;

    /**
     * True only when a new attempt is likely to succeed.
     */
    #[Required]
    public bool $retryable;

    /**
     * True only when X did not get the write and a new idempotency key may be used.
     */
    #[Required]
    public bool $safeToRetry;

    #[Required]
    public string $statusUrl;

    #[Required]
    public ?int $pollAfterMs;

    #[Required]
    public bool $charged;

    #[Required]
    public string $chargedCredits;

    /**
     * plannedCredits is the approved maximum. chargedCredits comes from the settled credit ledger. Xquik charges nothing for pending or failed writes.
     */
    #[Required]
    public XWriteActionBilling $billing;

    /**
     * Stable fingerprint and sanitized payload for replay checks.
     */
    #[Required]
    public XWriteActionRequest $request;

    /**
     * Connected account selected for the write.
     */
    #[Required]
    public ?XWriteActionAccount $account;

    /**
     * Existing X resource targeted by the write, when applicable.
     */
    #[Required]
    public ?XWriteActionTarget $target;

    #[Required('targetId')]
    public ?string $targetID;

    /**
     * Confirmed result produced by the write, when available.
     */
    #[Required]
    public ?XWriteActionResult $result;

    /**
     * Exact follow-up an API client or agent should perform.
     */
    #[Required]
    public ?XWriteActionNextAction $nextAction;

    #[Required]
    public bool $sendDispatched;

    #[Required]
    public bool $success;

    #[Optional]
    public ?string $requestHash;

    #[Optional('requestId')]
    public ?string $requestID;

    /**
     * True when this answers a retry of an earlier request with the same Idempotency-Key.
     */
    #[Optional]
    public ?bool $idempotent;

    #[Optional]
    public ?string $error;

    #[Optional]
    public ?string $message;

    /**
     * Dispatch timestamp when the write reached execution.
     */
    #[Optional]
    public ?\DateTimeInterface $sendDispatchedAt;

    #[Optional]
    public ?\DateTimeInterface $createdAt;

    #[Optional]
    public ?\DateTimeInterface $updatedAt;

    #[Optional]
    public ?\DateTimeInterface $completedAt;

    /**
     * Deadline for resolving a non-terminal write. This is not the Idempotency-Key retention deadline.
     */
    #[Optional]
    public ?\DateTimeInterface $expiresAt;

    #[Optional]
    public ?\DateTimeInterface $confirmedAt;

    #[Optional]
    public ?\DateTimeInterface $confirmationCheckedAt;

    #[Optional]
    public ?int $confirmationAttempts;

    /**
     * Compatibility field for a confirmed tweet result ID.
     */
    #[Optional('tweetId')]
    public ?string $tweetID;

    /**
     * Compatibility field for a confirmed direct message ID.
     */
    #[Optional('messageId')]
    public ?string $messageID;

    /**
     * Compatibility field for a confirmed media upload ID.
     */
    #[Optional('mediaId')]
    public ?string $mediaID;

    /**
     * Public media URL when the upload creates one.
     */
    #[Optional]
    public ?string $mediaUrl;

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

    /**
     * Compatibility result ID for other write actions.
     */
    #[Optional('resultId')]
    public ?string $resultID;

    /**
     * Media count, kind, size, and billing details when used.
     *
     * @var array<string,mixed>|null $media
     */
    #[Optional(map: 'mixed')]
    public ?array $media;

    /**
     * Structured recovery context for a failed write.
     *
     * @var array<string,mixed>|null $details
     */
    #[Optional(map: 'mixed')]
    public ?array $details;

    /**
     * `new XWriteAction()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * XWriteAction::with(object: ..., id: ..., writeActionID: ..., action: ..., status: ..., terminal: ..., retryable: ..., safeToRetry: ..., statusUrl: ..., pollAfterMs: ..., charged: ..., chargedCredits: ..., billing: ..., request: ..., account: ..., target: ..., targetID: ..., result: ..., nextAction: ..., sendDispatched: ..., success: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new XWriteAction)->withObject(...)->withId(...)->withWriteActionID(...)->withAction(...)->withStatus(...)->withTerminal(...)->withRetryable(...)->withSafeToRetry(...)->withStatusUrl(...)->withPollAfterMs(...)->withCharged(...)->withChargedCredits(...)->withBilling(...)->withRequest(...)->withAccount(...)->withTarget(...)->withTargetID(...)->withResult(...)->withNextAction(...)->withSendDispatched(...)->withSuccess(...)
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
     * @param ObjectModel|value-of<ObjectModel> $object
     * @param Action|value-of<Action> $action
     * @param Status|value-of<Status> $status
     * @param XWriteActionBilling|array<string,mixed> $billing
     * @param XWriteActionRequest|array<string,mixed> $request
     * @param XWriteActionAccount|array<string,mixed>|null $account
     * @param XWriteActionTarget|array<string,mixed>|null $target
     * @param XWriteActionResult|array<string,mixed>|null $result
     * @param XWriteActionNextAction|array<string,mixed>|null $nextAction
     * @param array<string,mixed>|null $media
     * @param array<string,mixed>|null $details
     */
    public static function with(ObjectModel|string $object, string $id, string $writeActionID, Action|string $action, Status|string $status, bool $terminal, bool $retryable, bool $safeToRetry, string $statusUrl, ?int $pollAfterMs, bool $charged, string $chargedCredits, XWriteActionBilling|array $billing, XWriteActionRequest|array $request, XWriteActionAccount|array|null $account, XWriteActionTarget|array|null $target, ?string $targetID, XWriteActionResult|array|null $result, XWriteActionNextAction|array|null $nextAction, bool $sendDispatched, bool $success, ?string $requestHash = null, ?string $requestID = null, ?bool $idempotent = null, ?string $error = null, ?string $message = null, ?\DateTimeInterface $sendDispatchedAt = null, ?\DateTimeInterface $createdAt = null, ?\DateTimeInterface $updatedAt = null, ?\DateTimeInterface $completedAt = null, ?\DateTimeInterface $expiresAt = null, ?\DateTimeInterface $confirmedAt = null, ?\DateTimeInterface $confirmationCheckedAt = null, ?int $confirmationAttempts = null, ?string $tweetID = null, ?string $messageID = null, ?string $mediaID = null, ?string $mediaUrl = null, ?string $communityID = null, ?string $communityName = null, ?string $resultID = null, ?array $media = null, ?array $details = null): self
    {
        $self = new self;

        $self['object'] = $object;
        $self['id'] = $id;
        $self['writeActionID'] = $writeActionID;
        $self['action'] = $action;
        $self['status'] = $status;
        $self['terminal'] = $terminal;
        $self['retryable'] = $retryable;
        $self['safeToRetry'] = $safeToRetry;
        $self['statusUrl'] = $statusUrl;
        $self['pollAfterMs'] = $pollAfterMs;
        $self['charged'] = $charged;
        $self['chargedCredits'] = $chargedCredits;
        $self['billing'] = $billing;
        $self['request'] = $request;
        $self['account'] = $account;
        $self['target'] = $target;
        $self['targetID'] = $targetID;
        $self['result'] = $result;
        $self['nextAction'] = $nextAction;
        $self['sendDispatched'] = $sendDispatched;
        $self['success'] = $success;

        null !== $requestHash && $self['requestHash'] = $requestHash;
        null !== $requestID && $self['requestID'] = $requestID;
        null !== $idempotent && $self['idempotent'] = $idempotent;
        null !== $error && $self['error'] = $error;
        null !== $message && $self['message'] = $message;
        null !== $sendDispatchedAt && $self['sendDispatchedAt'] = $sendDispatchedAt;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;
        null !== $completedAt && $self['completedAt'] = $completedAt;
        null !== $expiresAt && $self['expiresAt'] = $expiresAt;
        null !== $confirmedAt && $self['confirmedAt'] = $confirmedAt;
        null !== $confirmationCheckedAt && $self['confirmationCheckedAt'] = $confirmationCheckedAt;
        null !== $confirmationAttempts && $self['confirmationAttempts'] = $confirmationAttempts;
        null !== $tweetID && $self['tweetID'] = $tweetID;
        null !== $messageID && $self['messageID'] = $messageID;
        null !== $mediaID && $self['mediaID'] = $mediaID;
        null !== $mediaUrl && $self['mediaUrl'] = $mediaUrl;
        null !== $communityID && $self['communityID'] = $communityID;
        null !== $communityName && $self['communityName'] = $communityName;
        null !== $resultID && $self['resultID'] = $resultID;
        null !== $media && $self['media'] = $media;
        null !== $details && $self['details'] = $details;

        return $self;
    }

    /**
     * @param ObjectModel|value-of<ObjectModel> $object
     */
    public function withObject(ObjectModel|string $object): self
    {
        $self = clone $this;
        $self['object'] = $object;

        return $self;
    }

    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withWriteActionID(string $writeActionID): self
    {
        $self = clone $this;
        $self['writeActionID'] = $writeActionID;

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
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withTerminal(bool $terminal): self
    {
        $self = clone $this;
        $self['terminal'] = $terminal;

        return $self;
    }

    /**
     * True only when a new attempt is likely to succeed.
     */
    public function withRetryable(bool $retryable): self
    {
        $self = clone $this;
        $self['retryable'] = $retryable;

        return $self;
    }

    /**
     * True only when X did not get the write and a new idempotency key may be used.
     */
    public function withSafeToRetry(bool $safeToRetry): self
    {
        $self = clone $this;
        $self['safeToRetry'] = $safeToRetry;

        return $self;
    }

    public function withStatusUrl(string $statusUrl): self
    {
        $self = clone $this;
        $self['statusUrl'] = $statusUrl;

        return $self;
    }

    public function withPollAfterMs(?int $pollAfterMs): self
    {
        $self = clone $this;
        $self['pollAfterMs'] = $pollAfterMs;

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
     * plannedCredits is the approved maximum. chargedCredits comes from the settled credit ledger. Xquik charges nothing for pending or failed writes.
     *
     * @param XWriteActionBilling|array<string,mixed> $billing
     */
    public function withBilling(XWriteActionBilling|array $billing): self
    {
        $self = clone $this;
        $self['billing'] = $billing;

        return $self;
    }

    /**
     * Stable fingerprint and sanitized payload for replay checks.
     *
     * @param XWriteActionRequest|array<string,mixed> $request
     */
    public function withRequest(XWriteActionRequest|array $request): self
    {
        $self = clone $this;
        $self['request'] = $request;

        return $self;
    }

    /**
     * Connected account selected for the write.
     *
     * @param XWriteActionAccount|array<string,mixed>|null $account
     */
    public function withAccount(XWriteActionAccount|array|null $account): self
    {
        $self = clone $this;
        $self['account'] = $account;

        return $self;
    }

    /**
     * Existing X resource targeted by the write, when applicable.
     *
     * @param XWriteActionTarget|array<string,mixed>|null $target
     */
    public function withTarget(XWriteActionTarget|array|null $target): self
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

    /**
     * Confirmed result produced by the write, when available.
     *
     * @param XWriteActionResult|array<string,mixed>|null $result
     */
    public function withResult(XWriteActionResult|array|null $result): self
    {
        $self = clone $this;
        $self['result'] = $result;

        return $self;
    }

    /**
     * Exact follow-up an API client or agent should perform.
     *
     * @param XWriteActionNextAction|array<string,mixed>|null $nextAction
     */
    public function withNextAction(XWriteActionNextAction|array|null $nextAction): self
    {
        $self = clone $this;
        $self['nextAction'] = $nextAction;

        return $self;
    }

    public function withSendDispatched(bool $sendDispatched): self
    {
        $self = clone $this;
        $self['sendDispatched'] = $sendDispatched;

        return $self;
    }

    public function withSuccess(bool $success): self
    {
        $self = clone $this;
        $self['success'] = $success;

        return $self;
    }

    public function withRequestHash(?string $requestHash): self
    {
        $self = clone $this;
        $self['requestHash'] = $requestHash;

        return $self;
    }

    public function withRequestID(?string $requestID): self
    {
        $self = clone $this;
        $self['requestID'] = $requestID;

        return $self;
    }

    /**
     * True when this answers a retry of an earlier request with the same Idempotency-Key.
     */
    public function withIdempotent(?bool $idempotent): self
    {
        $self = clone $this;
        $self['idempotent'] = $idempotent;

        return $self;
    }

    public function withError(?string $error): self
    {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }

    public function withMessage(?string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }

    /**
     * Dispatch timestamp when the write reached execution.
     */
    public function withSendDispatchedAt(?\DateTimeInterface $sendDispatchedAt): self
    {
        $self = clone $this;
        $self['sendDispatchedAt'] = $sendDispatchedAt;

        return $self;
    }

    public function withCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    public function withCompletedAt(?\DateTimeInterface $completedAt): self
    {
        $self = clone $this;
        $self['completedAt'] = $completedAt;

        return $self;
    }

    /**
     * Deadline for resolving a non-terminal write. This is not the Idempotency-Key retention deadline.
     */
    public function withExpiresAt(?\DateTimeInterface $expiresAt): self
    {
        $self = clone $this;
        $self['expiresAt'] = $expiresAt;

        return $self;
    }

    public function withConfirmedAt(?\DateTimeInterface $confirmedAt): self
    {
        $self = clone $this;
        $self['confirmedAt'] = $confirmedAt;

        return $self;
    }

    public function withConfirmationCheckedAt(?\DateTimeInterface $confirmationCheckedAt): self
    {
        $self = clone $this;
        $self['confirmationCheckedAt'] = $confirmationCheckedAt;

        return $self;
    }

    public function withConfirmationAttempts(?int $confirmationAttempts): self
    {
        $self = clone $this;
        $self['confirmationAttempts'] = $confirmationAttempts;

        return $self;
    }

    /**
     * Compatibility field for a confirmed tweet result ID.
     */
    public function withTweetID(?string $tweetID): self
    {
        $self = clone $this;
        $self['tweetID'] = $tweetID;

        return $self;
    }

    /**
     * Compatibility field for a confirmed direct message ID.
     */
    public function withMessageID(?string $messageID): self
    {
        $self = clone $this;
        $self['messageID'] = $messageID;

        return $self;
    }

    /**
     * Compatibility field for a confirmed media upload ID.
     */
    public function withMediaID(?string $mediaID): self
    {
        $self = clone $this;
        $self['mediaID'] = $mediaID;

        return $self;
    }

    /**
     * Public media URL when the upload creates one.
     */
    public function withMediaUrl(?string $mediaUrl): self
    {
        $self = clone $this;
        $self['mediaUrl'] = $mediaUrl;

        return $self;
    }

    /**
     * Compatibility field for a confirmed community ID.
     */
    public function withCommunityID(?string $communityID): self
    {
        $self = clone $this;
        $self['communityID'] = $communityID;

        return $self;
    }

    /**
     * Confirmed community name when available.
     */
    public function withCommunityName(?string $communityName): self
    {
        $self = clone $this;
        $self['communityName'] = $communityName;

        return $self;
    }

    /**
     * Compatibility result ID for other write actions.
     */
    public function withResultID(?string $resultID): self
    {
        $self = clone $this;
        $self['resultID'] = $resultID;

        return $self;
    }

    /**
     * Media count, kind, size, and billing details when used.
     *
     * @param array<string,mixed>|null $media
     */
    public function withMedia(?array $media): self
    {
        $self = clone $this;
        $self['media'] = $media;

        return $self;
    }

    /**
     * Structured recovery context for a failed write.
     *
     * @param array<string,mixed>|null $details
     */
    public function withDetails(?array $details): self
    {
        $self = clone $this;
        $self['details'] = $details;

        return $self;
    }
}
