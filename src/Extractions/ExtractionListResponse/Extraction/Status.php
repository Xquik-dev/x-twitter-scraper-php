<?php

declare(strict_types=1);

namespace XTwitterScraper\Extractions\ExtractionListResponse\Extraction;

enum Status: string
{
    case RUNNING = 'running';

    case COMPLETED = 'completed';

    case FAILED = 'failed';
}
