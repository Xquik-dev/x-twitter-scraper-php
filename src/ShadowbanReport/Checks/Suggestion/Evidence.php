<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ShadowbanReport\Checks\Suggestion;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type EvidenceShape = array{
 *   query: string,
 *   suggestedUsernames: list<string>,
 * }
 */
final class Evidence implements BaseModel
{
    /** @use SdkModel<EvidenceShape> */
    use SdkModel;

    /**
     * The username it typed.
     */
    #[Required]
    public string $query;

    /**
     * Up to 10 accounts X suggested, in its order.
     *
     * @var list<string> $suggestedUsernames
     */
    #[Required(list: 'string')]
    public array $suggestedUsernames;

    /**
     * `new Evidence()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Evidence::with(query: ..., suggestedUsernames: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Evidence)->withQuery(...)->withSuggestedUsernames(...)
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
     * @param list<string> $suggestedUsernames
     */
    public static function with(string $query, array $suggestedUsernames): self
    {
        $self = new self;

        $self['query'] = $query;
        $self['suggestedUsernames'] = $suggestedUsernames;

        return $self;
    }

    /**
     * The username it typed.
     */
    public function withQuery(string $query): self
    {
        $self = clone $this;
        $self['query'] = $query;

        return $self;
    }

    /**
     * Up to 10 accounts X suggested, in its order.
     *
     * @param list<string> $suggestedUsernames
     */
    public function withSuggestedUsernames(array $suggestedUsernames): self
    {
        $self = clone $this;
        $self['suggestedUsernames'] = $suggestedUsernames;

        return $self;
    }
}
