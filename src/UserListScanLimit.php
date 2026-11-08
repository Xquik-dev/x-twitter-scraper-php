<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type UserListScanLimitShape = array{
 *   limit: int,
 *   rowsRead: int,
 *   message: string,
 * }
 */
final class UserListScanLimit implements BaseModel
{
    /** @use SdkModel<UserListScanLimitShape> */
    use SdkModel;

    /**
     * The profiles a filtered read scans of a list without maxScan.
     */
    #[Required]
    public int $limit;

    /**
     * Profiles the list read across its pages, kept or dropped by the filters. The last page may read past the limit.
     */
    #[Required]
    public int $rowsRead;

    /**
     * What stopped the list & how to read further.
     */
    #[Required]
    public string $message;

    /**
     * `new UserListScanLimit()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserListScanLimit::with(limit: ..., rowsRead: ..., message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserListScanLimit)->withLimit(...)->withRowsRead(...)->withMessage(...)
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
    public static function with(int $limit, int $rowsRead, string $message): self
    {
        $self = new self;

        $self['limit'] = $limit;
        $self['rowsRead'] = $rowsRead;
        $self['message'] = $message;

        return $self;
    }

    /**
     * The profiles a filtered read scans of a list without maxScan.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Profiles the list read across its pages, kept or dropped by the filters. The last page may read past the limit.
     */
    public function withRowsRead(int $rowsRead): self
    {
        $self = clone $this;
        $self['rowsRead'] = $rowsRead;

        return $self;
    }

    /**
     * What stopped the list & how to read further.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }
}
