<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Credits\CreditGetTopupStatusResponse;

enum Status: string
{
    case PAID = 'paid';

    case PROCESSING = 'processing';

    case FAILED = 'failed';

    case EXPIRED = 'expired';
}
