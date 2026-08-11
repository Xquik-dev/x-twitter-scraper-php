<?php

declare(strict_types=1);

namespace XTwitterScraper\Extractions\ExtractionRetrieveParams;

/**
 * Preserve source keys or convert result field names.
 */
enum FieldStyle: string
{
    case SOURCE = 'source';

    case CAMEL_CASE = 'camelCase';

    case SNAKE_CASE = 'snake_case';
}
