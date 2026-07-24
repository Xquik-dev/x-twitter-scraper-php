<?php

declare(strict_types=1);

use SebastianBergmann\CodeCoverage\CodeCoverage;
use SebastianBergmann\CodeCoverage\Report\Cobertura;

require dirname(__DIR__).'/vendor/autoload.php';

if ($argc < 3) {
    fwrite(STDERR, "Usage: php scripts/merge-coverage.php <cobertura.xml> <coverage.php>...\n");
    exit(2);
}

$coverage = null;
foreach (array_slice($argv, 2) as $coveragePath) {
    $part = require $coveragePath;
    if (!$part instanceof CodeCoverage) {
        fwrite(STDERR, "Coverage data is invalid: {$coveragePath}\n");
        exit(2);
    }

    if (null === $coverage) {
        $coverage = $part;
    } else {
        $coverage->merge($part);
    }
}

if (!$coverage instanceof CodeCoverage) {
    fwrite(STDERR, "No coverage data was provided.\n");
    exit(2);
}

(new Cobertura)->process($coverage, $argv[1]);
