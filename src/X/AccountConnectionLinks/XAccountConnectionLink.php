<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\AccountConnectionLinks;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\AccountConnectionLinks\XAccountConnectionLink\Purpose;
use XTwitterScraper\X\AccountConnectionLinks\XAccountConnectionLink\Status;

/**
 * A link where a person connects an X account on Xquik's page.
 *
 * @phpstan-type XAccountConnectionLinkShape = array{
 *   id: string,
 *   accountID: string|null,
 *   completedAt: \DateTimeInterface|null,
 *   createdAt: \DateTimeInterface,
 *   expiresAt: \DateTimeInterface,
 *   failure: string|null,
 *   health: string|null,
 *   object: 'x_account_connection_link',
 *   purpose: Purpose|value-of<Purpose>,
 *   reference: string|null,
 *   returnURL: string|null,
 *   status: Status|value-of<Status>,
 *   xUserID: string|null,
 *   xUsername: string|null,
 *   url?: string|null,
 * }
 */
final class XAccountConnectionLink implements BaseModel
{
    /** @use SdkModel<XAccountConnectionLinkShape> */
    use SdkModel;

    /** @var 'x_account_connection_link' $object */
    #[Required]
    public string $object = 'x_account_connection_link';

    #[Required]
    public string $id;

    #[Required('accountId')]
    public ?string $accountID;

    #[Required]
    public ?\DateTimeInterface $completedAt;

    #[Required]
    public \DateTimeInterface $createdAt;

    #[Required]
    public \DateTimeInterface $expiresAt;

    /**
     * Why the last login didn't finish.
     */
    #[Required]
    public ?string $failure;

    #[Required]
    public ?string $health;

    /** @var value-of<Purpose> $purpose */
    #[Required(enum: Purpose::class)]
    public string $purpose;

    #[Required]
    public ?string $reference;

    #[Required('returnUrl')]
    public ?string $returnURL;

    /**
     * `failed` means 5 logins were refused, so make a new link.
     *
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    #[Required('xUserId')]
    public ?string $xUserID;

    #[Required]
    public ?string $xUsername;

    /**
     * Present only in the response that creates the link.
     */
    #[Optional]
    public ?string $url;

    /**
     * `new XAccountConnectionLink()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * XAccountConnectionLink::with(
     *   id: ...,
     *   accountID: ...,
     *   completedAt: ...,
     *   createdAt: ...,
     *   expiresAt: ...,
     *   failure: ...,
     *   health: ...,
     *   purpose: ...,
     *   reference: ...,
     *   returnURL: ...,
     *   status: ...,
     *   xUserID: ...,
     *   xUsername: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new XAccountConnectionLink)
     *   ->withId(...)
     *   ->withAccountID(...)
     *   ->withCompletedAt(...)
     *   ->withCreatedAt(...)
     *   ->withExpiresAt(...)
     *   ->withFailure(...)
     *   ->withHealth(...)
     *   ->withPurpose(...)
     *   ->withReference(...)
     *   ->withReturnURL(...)
     *   ->withStatus(...)
     *   ->withXUserID(...)
     *   ->withXUsername(...)
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
     * @param Purpose|value-of<Purpose> $purpose
     * @param Status|value-of<Status> $status
     */
    public static function with(
        string $id,
        ?string $accountID,
        ?\DateTimeInterface $completedAt,
        \DateTimeInterface $createdAt,
        \DateTimeInterface $expiresAt,
        ?string $failure,
        ?string $health,
        Purpose|string $purpose,
        ?string $reference,
        ?string $returnURL,
        Status|string $status,
        ?string $xUserID,
        ?string $xUsername,
        ?string $url = null
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['accountID'] = $accountID;
        $self['completedAt'] = $completedAt;
        $self['createdAt'] = $createdAt;
        $self['expiresAt'] = $expiresAt;
        $self['failure'] = $failure;
        $self['health'] = $health;
        $self['purpose'] = $purpose;
        $self['reference'] = $reference;
        $self['returnURL'] = $returnURL;
        $self['status'] = $status;
        $self['xUserID'] = $xUserID;
        $self['xUsername'] = $xUsername;

        null !== $url && $self['url'] = $url;

        return $self;
    }

    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withAccountID(?string $accountID): self
    {
        $self = clone $this;
        $self['accountID'] = $accountID;

        return $self;
    }

    public function withCompletedAt(?\DateTimeInterface $completedAt): self
    {
        $self = clone $this;
        $self['completedAt'] = $completedAt;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withExpiresAt(\DateTimeInterface $expiresAt): self
    {
        $self = clone $this;
        $self['expiresAt'] = $expiresAt;

        return $self;
    }

    /**
     * Why the last login didn't finish.
     */
    public function withFailure(?string $failure): self
    {
        $self = clone $this;
        $self['failure'] = $failure;

        return $self;
    }

    public function withHealth(?string $health): self
    {
        $self = clone $this;
        $self['health'] = $health;

        return $self;
    }

    /**
     * @param 'x_account_connection_link' $object
     */
    public function withObject(string $object): self
    {
        $self = clone $this;
        $self['object'] = $object;

        return $self;
    }

    /**
     * @param Purpose|value-of<Purpose> $purpose
     */
    public function withPurpose(Purpose|string $purpose): self
    {
        $self = clone $this;
        $self['purpose'] = $purpose;

        return $self;
    }

    public function withReference(?string $reference): self
    {
        $self = clone $this;
        $self['reference'] = $reference;

        return $self;
    }

    public function withReturnURL(?string $returnURL): self
    {
        $self = clone $this;
        $self['returnURL'] = $returnURL;

        return $self;
    }

    /**
     * `failed` means 5 logins were refused, so make a new link.
     *
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withXUserID(?string $xUserID): self
    {
        $self = clone $this;
        $self['xUserID'] = $xUserID;

        return $self;
    }

    public function withXUsername(?string $xUsername): self
    {
        $self = clone $this;
        $self['xUsername'] = $xUsername;

        return $self;
    }

    /**
     * Present only in the response that creates the link.
     */
    public function withUrl(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
