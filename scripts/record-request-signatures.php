<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

use Tests\Support\RequestSignatures;

use const XTwitterScraper\VERSION;

$root = dirname(__DIR__);

require $root.'/vendor/autoload.php';

$record = $root.'/'.RequestSignatures::FILE;
$recorded = file_get_contents($record);
if (false === $recorded) {
    fwrite(STDERR, "Could not read {$record}.\n");

    exit(1);
}

try {
    $next = RequestSignatures::next($recorded, VERSION, RequestSignatures::read($root.'/src'));
} catch (RuntimeException $refusal) {
    fwrite(STDERR, $refusal->getMessage()."\n");

    exit(1);
}

file_put_contents($record, $next);
$methods = substr_count($next, "\n") - 1;
echo RequestSignatures::FILE." now records the {$methods} public methods of ".VERSION.".\n";
