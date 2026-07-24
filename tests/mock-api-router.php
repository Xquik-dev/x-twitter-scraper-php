<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

$remoteAddress = $_SERVER['REMOTE_ADDR'] ?? '';

if (!in_array($remoteAddress, ['127.0.0.1', '::1'], true)) {
    http_response_code(403);

    exit;
}

header('Content-Type: application/json');

$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$path = is_string($requestUri) ? parse_url($requestUri, PHP_URL_PATH) : null;

if ('/compose' === $path) {
    echo json_encode([
        'compositionGuidance' => [],
        'examplePatterns' => [],
        'intentUrl' => 'https://x.com/intent/post',
        'nextStep' => 'Review the draft.',
    ], JSON_THROW_ON_ERROR);

    exit;
}

if (is_string($path) && preg_match('#^/(draws|extractions)/[^/]+/export$#', $path)) {
    header('Content-Type: text/csv');
    echo "id\nexample\n";

    exit;
}

echo '{}';
