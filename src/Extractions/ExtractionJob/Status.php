<?php

declare(strict_types=1);

namespace XTwitterScraper\Extractions\ExtractionJob;

enum Status: string
{
    case RUNNING = 'running';

    case COMPLETED = 'completed';

    case FAILED = 'failed';
}
