<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ActivityRecord;

use XTwitterScraper\ActivityRecord\Related\Status;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type RelatedShape = array{
 *   id: string,
 *   type: string,
 *   status: \XTwitterScraper\ActivityRecord\Related\Status|value-of<\XTwitterScraper\ActivityRecord\Related\Status>,
 *   createdAt: \DateTimeInterface,
 *   url: string,
 * }
 */
final class Related implements BaseModel
{
    /** @use SdkModel<RelatedShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public string $type;

    /**
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    #[Required]
    public \DateTimeInterface $createdAt;

    #[Required]
    public string $url;

    /**
     * `new Related()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Related::with(id: ..., type: ..., status: ..., createdAt: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Related)->withId(...)->withType(...)->withStatus(...)->withCreatedAt(...)->withUrl(...)
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
     * @param Status|value-of<Status> $status
     */
    public static function with(string $id, string $type, Status|string $status, \DateTimeInterface $createdAt, string $url): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['type'] = $type;
        $self['status'] = $status;
        $self['createdAt'] = $createdAt;
        $self['url'] = $url;

        return $self;
    }

    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

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

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withUrl(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
