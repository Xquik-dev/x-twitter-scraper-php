<?php

declare(strict_types=1);

namespace XTwitterScraper\Compose\ComposeCreateParams;

/**
 * Workflow step.
 */
enum Step: string
{
    case COMPOSE = 'compose';

    case REFINE = 'refine';

    case SCORE = 'score';
}
