<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

const REPRODUCIBLE_TIMESTAMP = 946684800;

if (3 !== $argc) {
    fwrite(STDERR, "Usage: php scripts/normalize-archive.php <input.zip> <output.zip>\n");
    exit(2);
}

$input = new ZipArchive;
if (true !== $input->open($argv[1])) {
    fwrite(STDERR, "Input archive could not be opened.\n");
    exit(2);
}

$entries = [];
for ($index = 0; $index < $input->numFiles; ++$index) {
    $name = $input->getNameIndex($index);
    if (false === $name) {
        continue;
    }
    $contents = $input->getFromIndex($index);
    if (false === $contents) {
        $input->close();
        fwrite(STDERR, "Archive entry {$name} could not be read.\n");
        exit(2);
    }
    $entries[$name] = $contents;
}
$input->close();
ksort($entries, SORT_STRING);

$output = new ZipArchive;
if (true !== $output->open($argv[2], ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
    fwrite(STDERR, "Output archive could not be created.\n");
    exit(2);
}

foreach ($entries as $name => $contents) {
    $isDirectory = str_ends_with($name, '/');
    if ($isDirectory) {
        $output->addEmptyDir(rtrim($name, '/'));
    } else {
        $output->addFromString($name, $contents);
        $output->setCompressionName($name, ZipArchive::CM_DEFLATE, 9);
    }
    $output->setMtimeName($name, REPRODUCIBLE_TIMESTAMP);
    $mode = $isDirectory ? 0040755 : 0100644;
    $output->setExternalAttributesName($name, ZipArchive::OPSYS_UNIX, $mode << 16);
}

$output->setArchiveComment('');
$output->close();
