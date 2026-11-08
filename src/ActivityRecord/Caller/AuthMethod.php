<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ActivityRecord\Caller;

enum AuthMethod: string
{
    case API_KEY = 'api_key';

    case OAUTH = 'oauth';

    case SESSION = 'session';
}
