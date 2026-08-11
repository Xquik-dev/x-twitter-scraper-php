<?php

declare(strict_types=1);

namespace XTwitterScraper\Draws\DrawExportParams;

/**
 * Export output format. PDF entry exports include up to 10,000 rows. Other entry formats include up to 100,000 rows.
 */
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
