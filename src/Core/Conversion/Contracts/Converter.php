<?php

declare(strict_types=1);

namespace XTwitterScraper\Core\Conversion\Contracts;

use XTwitterScraper\Core\Conversion\CoerceState;
use XTwitterScraper\Core\Conversion\DumpState;

/**
 * @internal
 */
interface Converter
{
    /**
     * @internal
     */
    public function coerce(mixed $value, CoerceState $state): mixed;

    /**
     * @internal
     */
    public function dump(mixed $value, DumpState $state): mixed;
}
