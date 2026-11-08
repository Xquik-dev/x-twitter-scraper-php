<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ProfileContactInfo;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\ProfileContactInfo\Emails\Source;

/**
 * @phpstan-type EmailsShape = array{
 *   value: string,
 *   domain: string,
 *   source: Source|value-of<Source>,
 *   writtenAs?: string|null,
 * }
 */
final class Emails implements BaseModel
{
    /** @use SdkModel<EmailsShape> */
    use SdkModel;

    /**
     * The email address.
     */
    #[Required]
    public string $value;

    /**
     * The part after the @ sign.
     */
    #[Required]
    public string $domain;

    /**
     * Profile field that holds the email.
     *
     * @var value-of<Source> $source
     */
    #[Required(enum: Source::class)]
    public string $source;

    /**
     * The account's own spelling, sent when it spelled the email out.
     */
    #[Optional]
    public ?string $writtenAs;

    /**
     * `new Emails()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Emails::with(value: ..., domain: ..., source: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Emails)->withValue(...)->withDomain(...)->withSource(...)
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
     * @param Source|value-of<Source> $source
     */
    public static function with(string $value, string $domain, Source|string $source, ?string $writtenAs = null): self
    {
        $self = new self;

        $self['value'] = $value;
        $self['domain'] = $domain;
        $self['source'] = $source;

        null !== $writtenAs && $self['writtenAs'] = $writtenAs;

        return $self;
    }

    /**
     * The email address.
     */
    public function withValue(string $value): self
    {
        $self = clone $this;
        $self['value'] = $value;

        return $self;
    }

    /**
     * The part after the @ sign.
     */
    public function withDomain(string $domain): self
    {
        $self = clone $this;
        $self['domain'] = $domain;

        return $self;
    }

    /**
     * Profile field that holds the email.
     *
     * @param Source|value-of<Source> $source
     */
    public function withSource(Source|string $source): self
    {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }

    /**
     * The account's own spelling, sent when it spelled the email out.
     */
    public function withWrittenAs(?string $writtenAs): self
    {
        $self = clone $this;
        $self['writtenAs'] = $writtenAs;

        return $self;
    }
}
