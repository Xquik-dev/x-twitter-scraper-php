<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\ProfileContactInfo\Emails;
use XTwitterScraper\ProfileContactInfo\Links;
use XTwitterScraper\ProfileContactInfo\Phones;

/**
 * @phpstan-type ProfileContactInfoShape = array{
 *   emails?: list<Emails|array<string,mixed>>|null,
 *   phones?: list<Phones|array<string,mixed>>|null,
 *   links?: list<Links|array<string,mixed>>|null,
 * }
 */
final class ProfileContactInfo implements BaseModel
{
    /** @use SdkModel<ProfileContactInfoShape> */
    use SdkModel;

    /**
     * Emails in the bio, name or location, lowercased.
     *
     * @var list<Emails>|null $emails
     */
    #[Optional(list: Emails::class)]
    public ?array $emails;

    /**
     * Phone numbers on the profile. Only a spelling that can be nothing else counts.
     *
     * @var list<Phones>|null $phones
     */
    #[Optional(list: Phones::class)]
    public ?array $phones;

    /**
     * The profile's website & the links in its bio.
     *
     * @var list<Links>|null $links
     */
    #[Optional(list: Links::class)]
    public ?array $links;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<Emails|array<string,mixed>>|null $emails
     * @param list<Phones|array<string,mixed>>|null $phones
     * @param list<Links|array<string,mixed>>|null $links
     */
    public static function with(?array $emails = null, ?array $phones = null, ?array $links = null): self
    {
        $self = new self;

        null !== $emails && $self['emails'] = $emails;
        null !== $phones && $self['phones'] = $phones;
        null !== $links && $self['links'] = $links;

        return $self;
    }

    /**
     * Emails in the bio, name or location, lowercased.
     *
     * @param list<Emails|array<string,mixed>>|null $emails
     */
    public function withEmails(?array $emails): self
    {
        $self = clone $this;
        $self['emails'] = $emails;

        return $self;
    }

    /**
     * Phone numbers on the profile. Only a spelling that can be nothing else counts.
     *
     * @param list<Phones|array<string,mixed>>|null $phones
     */
    public function withPhones(?array $phones): self
    {
        $self = clone $this;
        $self['phones'] = $phones;

        return $self;
    }

    /**
     * The profile's website & the links in its bio.
     *
     * @param list<Links|array<string,mixed>>|null $links
     */
    public function withLinks(?array $links): self
    {
        $self = clone $this;
        $self['links'] = $links;

        return $self;
    }
}
