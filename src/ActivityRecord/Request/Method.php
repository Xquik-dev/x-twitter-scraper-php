<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ActivityRecord\Request;

enum Method: string
{
    case DELETE = 'DELETE';

    case PATCH = 'PATCH';

    case POST = 'POST';

    case PUT = 'PUT';
}
