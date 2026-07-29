<?php

declare(strict_types=1);

namespace XTwitterScraper\X\AccountConnectionAttempts\AccountConnectionAttemptGetResponse;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\AccountConnectionAttempts\AccountConnectionAttemptGetResponse\XAccountConnectionChallenge\Object_;
use XTwitterScraper\X\AccountConnectionAttempts\AccountConnectionAttemptGetResponse\XAccountConnectionChallenge\Status;

/**
 * Resumable account connection challenge. Submit the email code to finish the same connection attempt.
 *
 * @phpstan-type XAccountConnectionChallengeShape = array{
 *   id: string,
 *   expiresAt: \DateTimeInterface,
 *   message: string,
 *   object: Object_|value-of<Object_>,
 *   status: Status|value-of<Status>,
 *   username: string,
 * }
 */
final class XAccountConnectionChallenge implements BaseModel
{
    /** @use SdkModel<XAccountConnectionChallengeShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public \DateTimeInterface $expiresAt;

    #[Required]
    public string $message;

    /** @var value-of<Object_> $object */
    #[Required(enum: Object_::class)]
    public string $object;

    /** @var value-of<Status> $status */
    #[Required(enum: Status::class)]
    public string $status;

    #[Required]
    public string $username;

    /**
     * `new XAccountConnectionChallenge()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * XAccountConnectionChallenge::with(
     *   id: ..., expiresAt: ..., message: ..., object: ..., status: ..., username: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new XAccountConnectionChallenge)
     *   ->withID(...)
     *   ->withExpiresAt(...)
     *   ->withMessage(...)
     *   ->withObject(...)
     *   ->withStatus(...)
     *   ->withUsername(...)
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
     * @param Object_|value-of<Object_> $object
     * @param Status|value-of<Status> $status
     */
    public static function with(
        string $id,
        \DateTimeInterface $expiresAt,
        string $message,
        Object_|string $object,
        Status|string $status,
        string $username,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['expiresAt'] = $expiresAt;
        $self['message'] = $message;
        $self['object'] = $object;
        $self['status'] = $status;
        $self['username'] = $username;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withExpiresAt(\DateTimeInterface $expiresAt): self
    {
        $self = clone $this;
        $self['expiresAt'] = $expiresAt;

        return $self;
    }

    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }

    /**
     * @param Object_|value-of<Object_> $object
     */
    public function withObject(Object_|string $object): self
    {
        $self = clone $this;
        $self['object'] = $object;

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

    public function withUsername(string $username): self
    {
        $self = clone $this;
        $self['username'] = $username;

        return $self;
    }
}
