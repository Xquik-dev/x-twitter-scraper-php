<?php

declare(strict_types=1);

namespace XTwitterScraper\Extractions\ExtractionListParams;

/**
 * Filter by job status.
 */
enum Status: string
{
    case RUNNING = 'running';

    case COMPLETED = 'completed';

    case FAILED = 'failed';
}
