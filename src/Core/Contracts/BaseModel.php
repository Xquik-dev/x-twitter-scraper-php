<?php

declare(strict_types=1);

namespace XTwitterScraper\Core\Contracts;

use XTwitterScraper\Core\Conversion\Contracts\ConverterSource;

/**
 * @internal
 *
 * @extends \ArrayAccess<string, mixed>
 */
interface BaseModel extends \ArrayAccess, \JsonSerializable, \Stringable, ConverterSource
{
    /** @return array<string, mixed> */
    public function toProperties(): array;
}
