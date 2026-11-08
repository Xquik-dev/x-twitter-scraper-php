<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Lists;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\XList;

/**
 * @phpstan-type ListRetrieveResponseShape = array{
 *   list: XList|array<string,mixed>,
 * }
 */
final class ListRetrieveResponse implements BaseModel
{
    /** @use SdkModel<ListRetrieveResponseShape> */
    use SdkModel;

    /**
     * Public X List with its owner's public profile. It holds public fields only.
     */
    #[Required]
    public XList $list;

    /**
     * `new ListRetrieveResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ListRetrieveResponse::with(list: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ListRetrieveResponse)->withList(...)
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
     * @param XList|array<string,mixed> $list
     */
    public static function with(XList|array $list): self
    {
        $self = new self;

        $self['list'] = $list;

        return $self;
    }

    /**
     * Public X List with its owner's public profile. It holds public fields only.
     *
     * @param XList|array<string,mixed> $list
     */
    public function withList(XList|array $list): self
    {
        $self = clone $this;
        $self['list'] = $list;

        return $self;
    }
}
