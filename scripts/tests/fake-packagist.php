<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

// Stands in for Packagist in the audit tests. scripts/tests/audit.test.sh
// loads this file before scripts/verify-audit.php. It answers every HTTPS
// read from a file under FAKE_PACKAGIST_DIR and records the URL, so no test
// reaches the network. A package without a file acts like a failed download.

final class FakePackagist
{
    /** @var resource|null */
    public $context;

    private string $body = '';

    private int $offset = 0;

    public function stream_open(string $url, string $mode, int $options, ?string &$openedPath): bool
    {
        file_put_contents(getenv('FAKE_LOGS').'/packagist', $url."\n", FILE_APPEND);
        $prefix = 'https://repo.packagist.org/p2/';
        if (!str_starts_with($url, $prefix)) {
            return false;
        }
        $file = getenv('FAKE_PACKAGIST_DIR').'/'.str_replace('/', '__', substr($url, strlen($prefix)));
        if (!is_file($file)) {
            return false;
        }
        $this->body = (string) file_get_contents($file);

        return true;
    }

    public function stream_read(int $count): string
    {
        $chunk = substr($this->body, $this->offset, $count);
        $this->offset += strlen($chunk);

        return $chunk;
    }

    public function stream_eof(): bool
    {
        return $this->offset >= strlen($this->body);
    }

    /**
     * @return array<string, int>
     */
    public function stream_stat(): array
    {
        return [];
    }
}

stream_wrapper_unregister('https');
stream_wrapper_register('https', FakePackagist::class);
