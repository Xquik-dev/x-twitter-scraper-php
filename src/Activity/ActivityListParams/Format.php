<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Activity\ActivityListParams;

enum Format: string
{
    case JSON = 'json';

    case CSV = 'csv';

    case XLSX = 'xlsx';

    case MD = 'md';

    case MD_DOCUMENT = 'md-document';

    case PDF = 'pdf';

    case TXT = 'txt';
}
