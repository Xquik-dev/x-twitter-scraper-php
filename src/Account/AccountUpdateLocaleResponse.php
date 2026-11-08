<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Account;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type AccountUpdateLocaleResponseShape = array{success: bool,
 *   ignoredFields?: list<string>|null,
 * }
 */
final class AccountUpdateLocaleResponse implements BaseModel
{
    /** @use SdkModel<AccountUpdateLocaleResponseShape> */
    use SdkModel;

    #[Required]
    public bool $success = true;

    /**
     * Fields the request sent that this route does not read, in the order sent. They changed nothing. The answer leaves this out when the route read every field.
     *
     * @var list<string>|null $ignoredFields
     */
    #[Optional(list: 'string')]
    public ?array $ignoredFields;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $ignoredFields
     */
    public static function with(?array $ignoredFields = null): self
    {
        $self = new self;

        null !== $ignoredFields && $self['ignoredFields'] = $ignoredFields;

        return $self;
    }

    public function withSuccess(bool $success): self
    {
        $self = clone $this;
        $self['success'] = $success;

        return $self;
    }

    /**
     * Fields the request sent that this route does not read, in the order sent. They changed nothing. The answer leaves this out when the route read every field.
     *
     * @param list<string>|null $ignoredFields
     */
    public function withIgnoredFields(?array $ignoredFields): self
    {
        $self = clone $this;
        $self['ignoredFields'] = $ignoredFields;

        return $self;
    }
}
