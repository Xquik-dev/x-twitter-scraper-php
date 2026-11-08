<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Communities\CommunityGetInfoResponse\Community\Creator;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type UsernameChangesShape = array{
 *   count: int,
 *   lastChangedAt?: \DateTimeInterface|null,
 * }
 */
final class UsernameChanges implements BaseModel
{
    /** @use SdkModel<UsernameChangesShape> */
    use SdkModel;

    /**
     * Whole number from 0.
     */
    #[Required]
    public int $count;

    /**
     * Time of the latest change, omitted when there is none.
     */
    #[Optional]
    public ?\DateTimeInterface $lastChangedAt;

    /**
     * `new UsernameChanges()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UsernameChanges::with(count: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UsernameChanges)->withCount(...)
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
    public static function with(int $count, ?\DateTimeInterface $lastChangedAt = null): self
    {
        $self = new self;

        $self['count'] = $count;

        null !== $lastChangedAt && $self['lastChangedAt'] = $lastChangedAt;

        return $self;
    }

    /**
     * Whole number from 0.
     */
    public function withCount(int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

        return $self;
    }

    /**
     * Time of the latest change, omitted when there is none.
     */
    public function withLastChangedAt(?\DateTimeInterface $lastChangedAt): self
    {
        $self = clone $this;
        $self['lastChangedAt'] = $lastChangedAt;

        return $self;
    }
}
