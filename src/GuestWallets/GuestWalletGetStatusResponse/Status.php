<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\GuestWallets\GuestWalletGetStatusResponse;

/**
 * Combined wallet and pending-checkout state. A pending top-up can coexist with usable true. Terminal expired or failed states require a new guest wallet.
 */
enum Status: string
{
    case ACTIVE = 'active';

    case PENDING = 'pending';

    case EXPIRED = 'expired';

    case FAILED = 'failed';

    case FROZEN = 'frozen';

    case CLOSED = 'closed';
}
