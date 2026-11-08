<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ProfileContactInfo\Emails;

enum Source: string
{
    case BIO = 'bio';

    case NAME = 'name';

    case LOCATION = 'location';
}
