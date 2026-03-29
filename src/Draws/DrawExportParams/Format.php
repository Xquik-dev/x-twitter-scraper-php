<?php

declare(strict_types=1);

namespace XTwitterScraper\Draws\DrawExportParams;

enum Format: string
{
    case CSV = 'csv';

    case JSON = 'json';

    case MD = 'md';

    case MD_DOCUMENT = 'md-document';

    case PDF = 'pdf';

    case TXT = 'txt';

    case XLSX = 'xlsx';
}
