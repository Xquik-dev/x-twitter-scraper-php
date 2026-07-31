<?php

declare(strict_types=1);

namespace XTwitterScraper\X\AccountConnectionAttempts\AccountConnectionAttemptGetResponse;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Resumable account connection challenge. Submit the email code to finish the same connection attempt.
 *
 * @phpstan-type XAccountConnectionChallengeShape = array{
 *   id: string,
 *   expiresAt: \DateTimeInterface,
 *   message: string,
 *   object: 'x_account_connection_challenge',
 *   status: 'requires_email_code',
 *   username: string,
 * }
 */
final class XAccountConnectionChallenge implements BaseModel
{
    /** @use SdkModel<XAccountConnectionChallengeShape> */
    use SdkModel;

    /** @var 'x_account_connection_challenge' $object */
    #[Required]
    public string $object = 'x_account_connection_challenge';

    /** @var 'requires_email_code' $status */
    #[Required]
    public string $status = 'requires_email_code';

    #[Required]
    public string $id;

    #[Required]
    public \DateTimeInterface $expiresAt;

    #[Required]
    public string $message;

    #[Required]
    public string $username;

    /**
     * `new XAccountConnectionChallenge()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * XAccountConnectionChallenge::with(
     *   id: ..., expiresAt: ..., message: ..., username: ...
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
     */
    public static function with(
        string $id,
        \DateTimeInterface $expiresAt,
        string $message,
        string $username
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['expiresAt'] = $expiresAt;
        $self['message'] = $message;
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
     * @param 'x_account_connection_challenge' $object
     */
    public function withObject(string $object): self
    {
        $self = clone $this;
        $self['object'] = $object;

        return $self;
    }

    /**
     * @param 'requires_email_code' $status
     */
    public function withStatus(string $status): self
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
