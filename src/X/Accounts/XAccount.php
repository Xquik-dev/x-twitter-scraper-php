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
use XTwitterScraper\X\Accounts\XAccount\Health;

/**
 * Linked X account summary with connection status, health, and timestamp metadata.
 *
 * @phpstan-type XAccountShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   health: Health|value-of<Health>,
 *   status: string,
 *   updatedAt: \DateTimeInterface,
 *   xUserID: string,
 *   xUsername: string,
 *   cookiesObtainedAt?: \DateTimeInterface|null,
 * }
 */
final class XAccount implements BaseModel
{
    /** @use SdkModel<XAccountShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public \DateTimeInterface $createdAt;

    /**
     * Derived connection health. `healthy` = session active. `needsReauth` = user must submit fresh credentials. `locked` = X locked the account; unlock on x.com first. `suspended` = X banned the account. `recovering` = past cooldown, will auto-retry on next use. `temporaryIssue` = temporary connection problem; retry shortly.
     *
     * @var value-of<Health> $health
     */
    #[Required(enum: Health::class)]
    public string $health;

    #[Required]
    public string $status;

    #[Required]
    public \DateTimeInterface $updatedAt;

    #[Required('xUserId')]
    public string $xUserID;

    #[Required]
    public string $xUsername;

    #[Optional]
    public ?\DateTimeInterface $cookiesObtainedAt;

    /**
     * `new XAccount()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * XAccount::with(
     *   id: ...,
     *   createdAt: ...,
     *   health: ...,
     *   status: ...,
     *   updatedAt: ...,
     *   xUserID: ...,
     *   xUsername: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new XAccount)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withHealth(...)
     *   ->withStatus(...)
     *   ->withUpdatedAt(...)
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
        \DateTimeInterface $updatedAt,
        string $xUserID,
        string $xUsername,
        ?\DateTimeInterface $cookiesObtainedAt = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['health'] = $health;
        $self['status'] = $status;
        $self['updatedAt'] = $updatedAt;
        $self['xUserID'] = $xUserID;
        $self['xUsername'] = $xUsername;

        null !== $cookiesObtainedAt && $self['cookiesObtainedAt'] = $cookiesObtainedAt;

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
     * Derived connection health. `healthy` = session active. `needsReauth` = user must submit fresh credentials. `locked` = X locked the account; unlock on x.com first. `suspended` = X banned the account. `recovering` = past cooldown, will auto-retry on next use. `temporaryIssue` = temporary connection problem; retry shortly.
     *
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

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

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
}
