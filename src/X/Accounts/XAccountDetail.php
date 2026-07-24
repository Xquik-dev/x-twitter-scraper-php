<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Accounts;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Accounts\XAccountDetail\Health;

/**
 * Connected X account details with health and timestamp metadata.
 *
 * @phpstan-type XAccountDetailShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   health: Health|value-of<Health>,
 *   status: string,
 *   xUserID: string,
 *   xUsername: string,
 *   cookiesObtainedAt?: \DateTimeInterface|null,
 *   updatedAt?: \DateTimeInterface|null,
 * }
 */
final class XAccountDetail implements BaseModel
{
    /** @use SdkModel<XAccountDetailShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public \DateTimeInterface $createdAt;

    /** @var value-of<Health> $health */
    #[Required(enum: Health::class)]
    public string $health;

    #[Required]
    public string $status;

    #[Required('xUserId')]
    public string $xUserID;

    #[Required]
    public string $xUsername;

    #[Optional]
    public ?\DateTimeInterface $cookiesObtainedAt;

    #[Optional]
    public ?\DateTimeInterface $updatedAt;

    /**
     * `new XAccountDetail()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * XAccountDetail::with(
     *   id: ...,
     *   createdAt: ...,
     *   health: ...,
     *   status: ...,
     *   xUserID: ...,
     *   xUsername: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new XAccountDetail)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withHealth(...)
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
     * @param Health|value-of<Health> $health
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        Health|string $health,
        string $status,
        string $xUserID,
        string $xUsername,
        ?\DateTimeInterface $cookiesObtainedAt = null,
        ?\DateTimeInterface $updatedAt = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['health'] = $health;
        $self['status'] = $status;
        $self['xUserID'] = $xUserID;
        $self['xUsername'] = $xUsername;

        null !== $cookiesObtainedAt && $self['cookiesObtainedAt'] = $cookiesObtainedAt;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;

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

    /**
     * @param Health|value-of<Health> $health
     */
    public function withHealth(Health|string $health): self
    {
        $self = clone $this;
        $self['health'] = $health;

        return $self;
    }

    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withXUserID(string $xUserID): self
    {
        $self = clone $this;
        $self['xUserID'] = $xUserID;

        return $self;
    }

    public function withXUsername(string $xUsername): self
    {
        $self = clone $this;
        $self['xUsername'] = $xUsername;

        return $self;
    }

    public function withCookiesObtainedAt(
        \DateTimeInterface $cookiesObtainedAt
    ): self {
        $self = clone $this;
        $self['cookiesObtainedAt'] = $cookiesObtainedAt;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
