<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\AccountConnectionLinks\XAccountConnectionLink;

/**
 * `failed` means 5 logins were refused, so make a new link.
 */
enum Status: string
{
    case PENDING = 'pending';

    case CONNECTING = 'connecting';

    case REQUIRES_EMAIL_CODE = 'requires_email_code';

    case CONNECTED = 'connected';

    case FAILED = 'failed';

    case EXPIRED = 'expired';

    case REVOKED = 'revoked';
}
