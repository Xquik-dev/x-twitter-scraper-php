<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Communities;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Create community.
 *
 * @see XTwitterScraper\Services\X\CommunitiesService::create()
 *
 * @phpstan-type CommunityCreateParamsShape = array{
 *   account: string,
 *   name: string,
 *   idempotencyKey: string,
 *   description?: string|null,
 * }
 */
final class CommunityCreateParams implements BaseModel
{
    /** @use SdkModel<CommunityCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * X account (@username or ID) creating the community.
     */
    #[Required]
    public string $account;

    /**
     * Community name.
     */
    #[Required]
    public string $name;

    #[Required]
    public string $idempotencyKey;

    /**
     * Community description.
     */
    #[Optional]
    public ?string $description;

    /**
     * `new CommunityCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CommunityCreateParams::with(account: ..., name: ..., idempotencyKey: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CommunityCreateParams)
     *   ->withAccount(...)
     *   ->withName(...)
     *   ->withIdempotencyKey(...)
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
        string $account,
        string $name,
        string $idempotencyKey,
        ?string $description = null,
    ): self {
        $self = new self;

        $self['account'] = $account;
        $self['name'] = $name;
        $self['idempotencyKey'] = $idempotencyKey;

        null !== $description && $self['description'] = $description;

        return $self;
    }

    /**
     * X account (@username or ID) creating the community.
     */
    public function withAccount(string $account): self
    {
        $self = clone $this;
        $self['account'] = $account;

        return $self;
    }

    /**
     * Community name.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    /**
     * Community description.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }
}
