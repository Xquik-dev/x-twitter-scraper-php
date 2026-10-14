<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

const MINIMUM_LINE_PERCENT = 90;
const MINIMUM_BRANCH_PERCENT = 80;

if (!isset($argc, $argv) || 2 !== $argc) {
    fwrite(STDERR, "Usage: php scripts/verify-coverage.php <cobertura.xml>\n");

    exit(2);
}

libxml_use_internal_errors(true);
$document = new DOMDocument;
$loaded = $document->load($argv[1], LIBXML_NONET);
$summary = $document->documentElement;
if (!$loaded || null === $summary || 'coverage' !== $summary->tagName) {
    fwrite(STDERR, "Coverage report is invalid. Regenerate it.\n");

    exit(2);
}

$exit = 0;
foreach ([
    'Executable lines' => ['lines', 'line', MINIMUM_LINE_PERCENT],
    'Branches' => ['branches', 'branch', MINIMUM_BRANCH_PERCENT],
] as $label => [$plural, $singular, $minimum]) {
    $covered = filter_var($summary->getAttribute($plural.'-covered'), FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
    $total = filter_var($summary->getAttribute($plural.'-valid'), FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
    $rate = filter_var($summary->getAttribute($singular.'-rate'), FILTER_VALIDATE_FLOAT);
    if (false === $covered || false === $total || $covered > $total || false === $rate) {
        fwrite(STDERR, "Coverage report has invalid {$plural} counts. Regenerate it.\n");

        exit(2);
    }
    $ratio = 0 === $total ? 0.0 : $covered / $total;
    if ($rate !== (float) (string) $ratio) {
        fwrite(STDERR, "Coverage report has inconsistent {$singular} rate. Regenerate it.\n");

        exit(2);
    }
    printf("%s: %d/%d (%.2f%%)\n", $label, $covered, $total, 100 * $ratio);
    $required = intdiv($total, 100) * $minimum + intdiv(($total % 100) * $minimum + 99, 100);
    if (0 === $total || $covered < $required) {
        fwrite(STDERR, "{$label} coverage is below {$minimum}%. Add tests.\n");
        $exit = 1;
    }
}

exit($exit);
