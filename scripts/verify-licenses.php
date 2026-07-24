<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

$approved = [
    'Apache-2.0',
    'BSD-2-Clause',
    'BSD-3-Clause',
    'ISC',
    'MIT',
];

$input = stream_get_contents(STDIN);
$report = json_decode($input, true, flags: JSON_THROW_ON_ERROR);
$dependencies = $report['dependencies'] ?? null;
if (!is_array($dependencies)) {
    fwrite(STDERR, "Composer license output is invalid.\n");
    exit(2);
}

$rejected = [];
foreach ($dependencies as $name => $metadata) {
    $licenses = $metadata['license'] ?? [];
    if (!is_array($licenses) || [] === array_intersect($licenses, $approved)) {
        $rejected[$name] = is_array($licenses) ? implode(' OR ', $licenses) : 'unknown';
    }
}

if ([] !== $rejected) {
    foreach ($rejected as $name => $license) {
        fwrite(STDERR, "{$name}: unapproved license {$license}\n");
    }
    fwrite(STDERR, "A maintainer must review every new dependency license.\n");
    exit(1);
}

printf("Verified %d dependency licenses.\n", count($dependencies));
