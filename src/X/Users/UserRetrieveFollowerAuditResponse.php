<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Users;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\FollowerAudit;

/**
 * @phpstan-type UserRetrieveFollowerAuditResponseShape = array{
 *   audit: FollowerAudit|array<string,mixed>,
 * }
 */
final class UserRetrieveFollowerAuditResponse implements BaseModel
{
    /** @use SdkModel<UserRetrieveFollowerAuditResponseShape> */
    use SdkModel;

    /**
     * Report on the followers read. Classes rest on public profile signals, so they say what a profile looks like, never who runs it.
     */
    #[Required]
    public FollowerAudit $audit;

    /**
     * `new UserRetrieveFollowerAuditResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserRetrieveFollowerAuditResponse::with(audit: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserRetrieveFollowerAuditResponse)->withAudit(...)
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
     * @param FollowerAudit|array<string,mixed> $audit
     */
    public static function with(FollowerAudit|array $audit): self
    {
        $self = new self;

        $self['audit'] = $audit;

        return $self;
    }

    /**
     * Report on the followers read. Classes rest on public profile signals, so they say what a profile looks like, never who runs it.
     *
     * @param FollowerAudit|array<string,mixed> $audit
     */
    public function withAudit(FollowerAudit|array $audit): self
    {
        $self = clone $this;
        $self['audit'] = $audit;

        return $self;
    }
}
