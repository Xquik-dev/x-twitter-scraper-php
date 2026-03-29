<?php

declare(strict_types=1);

namespace XTwitterScraper\Extractions\ExtractionListParams;

enum Status: string
{
    case RUNNING = 'running';

    case COMPLETED = 'completed';

    case FAILED = 'failed';
}
