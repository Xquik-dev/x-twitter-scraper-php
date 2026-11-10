<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\AccountConnectionLinks;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Create X account connect link.
 *
 * @see XTwitterScraper\Services\X\AccountConnectionLinksService::create()
 *
 * @phpstan-type AccountConnectionLinkCreateParamsShape = array{
 *   accountID?: string|null,
 *   reference?: string|null,
 *   returnURL?: string|null,
 * }
 */
final class AccountConnectionLinkCreateParams implements BaseModel
{
    /** @use SdkModel<AccountConnectionLinkCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The ID of 1 of your X accounts. The link then reconnects that account.
     */
    #[Optional('accountId')]
    public ?string $accountID;

    /**
     * Your own ID for this person. It comes back when you read the link.
     */
    #[Optional]
    public ?string $reference;

    /**
     * A public https URL the page offers as a button once the account connects. Xquik never redirects by itself, & never adds the token.
     */
    #[Optional('returnUrl')]
    public ?string $returnURL;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        ?string $accountID = null,
        ?string $reference = null,
        ?string $returnURL = null
    ): self {
        $self = new self;

        null !== $accountID && $self['accountID'] = $accountID;
        null !== $reference && $self['reference'] = $reference;
        null !== $returnURL && $self['returnURL'] = $returnURL;

        return $self;
    }

    /**
     * The ID of 1 of your X accounts. The link then reconnects that account.
     */
    public function withAccountID(string $accountID): self
    {
        $self = clone $this;
        $self['accountID'] = $accountID;

        return $self;
    }

    /**
     * Your own ID for this person. It comes back when you read the link.
     */
    public function withReference(string $reference): self
    {
        $self = clone $this;
        $self['reference'] = $reference;

        return $self;
    }

    /**
     * A public https URL the page offers as a button once the account connects. Xquik never redirects by itself, & never adds the token.
     */
    public function withReturnURL(string $returnURL): self
    {
        $self = clone $this;
        $self['returnURL'] = $returnURL;

        return $self;
    }
}
