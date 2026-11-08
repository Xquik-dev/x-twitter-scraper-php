<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Extractions;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Extractions\ExtractionCancelResponse\Status;

/**
 * @phpstan-type ExtractionCancelResponseShape = array{
 *   id: string,
 *   status: Status|value-of<Status>,
 * }
 */
final class ExtractionCancelResponse implements BaseModel
{
    /** @use SdkModel<ExtractionCancelResponseShape> */
    use SdkModel;

    #[Required]
    public string $id;

    /**
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    /**
     * `new ExtractionCancelResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ExtractionCancelResponse::with(id: ..., status: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ExtractionCancelResponse)->withId(...)->withStatus(...)
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
    public static function with(string $id, Status|string $status): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['status'] = $status;

        return $self;
    }

    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

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
}
