<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

const MINIMUM_LINE_RATE = 0.90;
const MINIMUM_BRANCH_RATE = 0.80;

if (2 !== $argc) {
    fwrite(STDERR, "Usage: php scripts/verify-coverage.php <cobertura.xml>\n");
    exit(2);
}

$report = file_get_contents($argv[1]);
if (false === $report) {
    fwrite(STDERR, "Could not read the coverage report. Check the file path.\n");
    exit(2);
}

if (!preg_match('/<coverage\b([^>]*)>/', $report, $coverageMatch)) {
    fwrite(STDERR, "Coverage report omits its summary. Regenerate coverage.\n");
    exit(2);
}

$attributes = [];
preg_match_all('/([a-z-]+)="([^"]+)"/', $coverageMatch[1], $attributeMatches, PREG_SET_ORDER);
foreach ($attributeMatches as $attributeMatch) {
    $attributes[$attributeMatch[1]] = $attributeMatch[2];
}

$required = [
    'line-rate',
    'branch-rate',
    'lines-covered',
    'lines-valid',
    'branches-covered',
    'branches-valid',
];
foreach ($required as $name) {
    if (!array_key_exists($name, $attributes) || !is_numeric($attributes[$name])) {
        fwrite(STDERR, "Coverage report omits {$name}. Regenerate coverage.\n");
        exit(2);
    }
}

$lineRate = (float) $attributes['line-rate'];
$branchRate = (float) $attributes['branch-rate'];
$lineSummary = sprintf(
    '%s/%s (%.2f%%)',
    $attributes['lines-covered'],
    $attributes['lines-valid'],
    100 * $lineRate,
);
$branchSummary = sprintf(
    '%s/%s (%.2f%%)',
    $attributes['branches-covered'],
    $attributes['branches-valid'],
    100 * $branchRate,
);

echo "Executable lines: {$lineSummary}\n";
echo "Branches: {$branchSummary}\n";

$failed = false;
if ($lineRate < MINIMUM_LINE_RATE) {
    fwrite(STDERR, "Executable line coverage is below 90%. Add tests.\n");
    $failed = true;
}
if ($branchRate < MINIMUM_BRANCH_RATE) {
    fwrite(STDERR, "Branch coverage is below 80%. Add branch tests.\n");
    $failed = true;
}

exit($failed ? 1 : 0);
