<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Error\Error\StructuredError;

enum Type: string
{
    case API_ERROR = 'api_error';

    case AUTHENTICATION_ERROR = 'authentication_error';

    case BILLING_ERROR = 'billing_error';

    case DEPENDENCY_ERROR = 'dependency_error';

    case INVALID_REQUEST_ERROR = 'invalid_request_error';

    case PERMISSION_ERROR = 'permission_error';

    case RATE_LIMIT_ERROR = 'rate_limit_error';
}
