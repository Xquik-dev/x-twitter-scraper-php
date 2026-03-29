<?php

declare(strict_types=1);

namespace XTwitterScraper\Core\Conversion;

use XTwitterScraper\Core\Conversion\Concerns\ArrayOf;
use XTwitterScraper\Core\Conversion\Contracts\Converter;

/**
 * @internal
 */
final class MapOf implements Converter
{
    use ArrayOf;
}
