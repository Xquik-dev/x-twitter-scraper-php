<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Monitors\Posts;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Monitors\Posts\PostDeleteResponse\DeletionStatus;

/**
 * @phpstan-type PostDeleteResponseShape = array{
 *   deletionStatus: DeletionStatus|value-of<DeletionStatus>,
 *   statusUrl: string,
 *   success: bool,
 * }
 */
final class PostDeleteResponse implements BaseModel
{
    /** @use SdkModel<PostDeleteResponseShape> */
    use SdkModel;

    /**
     * @var value-of<DeletionStatus> $deletionStatus
     */
    #[Required(enum: DeletionStatus::class)]
    public string $deletionStatus;

    /**
     * Poll this monitor URL until it returns 404.
     */
    #[Required]
    public string $statusUrl;

    #[Required]
    public bool $success;

    /**
     * `new PostDeleteResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PostDeleteResponse::with(deletionStatus: ..., statusUrl: ..., success: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PostDeleteResponse)->withDeletionStatus(...)->withStatusUrl(...)->withSuccess(...)
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
     * @param DeletionStatus|value-of<DeletionStatus> $deletionStatus
     */
    public static function with(DeletionStatus|string $deletionStatus, string $statusUrl, bool $success): self
    {
        $self = new self;

        $self['deletionStatus'] = $deletionStatus;
        $self['statusUrl'] = $statusUrl;
        $self['success'] = $success;

        return $self;
    }

    /**
     * @param DeletionStatus|value-of<DeletionStatus> $deletionStatus
     */
    public function withDeletionStatus(DeletionStatus|string $deletionStatus): self
    {
        $self = clone $this;
        $self['deletionStatus'] = $deletionStatus;

        return $self;
    }

    /**
     * Poll this monitor URL until it returns 404.
     */
    public function withStatusUrl(string $statusUrl): self
    {
        $self = clone $this;
        $self['statusUrl'] = $statusUrl;

        return $self;
    }

    public function withSuccess(bool $success): self
    {
        $self = clone $this;
        $self['success'] = $success;

        return $self;
    }
}
