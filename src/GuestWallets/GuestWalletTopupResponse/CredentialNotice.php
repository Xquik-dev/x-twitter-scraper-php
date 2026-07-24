<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\GuestWallets\GuestWalletTopupResponse;

enum CredentialNotice: string
{
    case STORE_API_KEY_AND_THE_IDEMPOTENCY_KEY_SECURELY_BEFORE_SHARING_CHECKOUT_URL_NO_EMAIL_RECOVERY_IS_AVAILABLE = 'Store api_key and the Idempotency-Key securely before sharing checkout_url. No email recovery is available.';
}
