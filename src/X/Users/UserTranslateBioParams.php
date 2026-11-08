<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Users;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Returns X's own translation of 1 profile's bio into the language you pick, with the links, mentions, and tags X places in the translated text. A profile without a bio returns translation null & a message, free of charge.
 *
 * @see XTwitterScraper\Services\X\UsersService::translateBio()
 *
 * @phpstan-type UserTranslateBioParamsShape = array{
 *   language: string,
 *   fields?: string|null,
 *   omit?: string|null,
 * }
 */
final class UserTranslateBioParams implements BaseModel
{
    /** @use SdkModel<UserTranslateBioParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Language code to translate into, such as `es`, `tr`, `pt-br`, or `zh-tw`. Upper and lower case both work.
     */
    #[Required]
    public string $language;

    /**
     * Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     */
    #[Optional]
    public ?string $fields;

    /**
     * Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     */
    #[Optional]
    public ?string $omit;

    /**
     * `new UserTranslateBioParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserTranslateBioParams::with(language: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserTranslateBioParams)->withLanguage(...)
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
    public static function with(string $language, ?string $fields = null, ?string $omit = null): self
    {
        $self = new self;

        $self['language'] = $language;

        null !== $fields && $self['fields'] = $fields;
        null !== $omit && $self['omit'] = $omit;

        return $self;
    }

    /**
     * Language code to translate into, such as `es`, `tr`, `pt-br`, or `zh-tw`. Upper and lower case both work.
     */
    public function withLanguage(string $language): self
    {
        $self = clone $this;
        $self['language'] = $language;

        return $self;
    }

    /**
     * Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     */
    public function withFields(?string $fields): self
    {
        $self = clone $this;
        $self['fields'] = $fields;

        return $self;
    }

    /**
     * Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     */
    public function withOmit(?string $omit): self
    {
        $self = clone $this;
        $self['omit'] = $omit;

        return $self;
    }
}
