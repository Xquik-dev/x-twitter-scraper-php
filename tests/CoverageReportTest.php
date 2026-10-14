<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;

/** @internal */
final class CoverageReportTest extends TestCase
{
    #[DataProvider('impossibleCounts')]
    public function testRejectsImpossibleCoverageCounts(string $counts): void
    {
        $report = tempnam(sys_get_temp_dir(), 'coverage-report-');
        if (false === $report) {
            throw new \RuntimeException('Could not create coverage fixture.');
        }

        try {
            $valid = '<coverage line-rate="0.9" lines-covered="9" lines-valid="10" branch-rate="0.8" branches-covered="4" branches-valid="5"></coverage>';
            $this->assertSame(strlen($valid), file_put_contents($report, $valid));
            $process = new Process(
                [PHP_BINARY, __DIR__.'/../scripts/verify-coverage.php', $report],
            );
            $process->setTimeout(5);
            $process->run();
            $this->assertSame(0, $process->getExitCode(), $process->getOutput().$process->getErrorOutput());
            $xml = '<coverage '.$counts.'></coverage>';
            $this->assertSame(strlen($xml), file_put_contents($report, $xml));
            $process->run();
            $this->assertSame(2, $process->getExitCode(), $process->getOutput().$process->getErrorOutput());
        } finally {
            unlink($report);
        }
    }

    /** @return iterable<string, array{string}> */
    public static function impossibleCounts(): iterable
    {
        yield 'negative line total' => ['line-rate="0" lines-covered="0" lines-valid="-1" branch-rate="1" branches-covered="1" branches-valid="1"'];

        yield 'covered lines exceed total' => ['line-rate="1.1" lines-covered="11" lines-valid="10" branch-rate="1" branches-covered="1" branches-valid="1"'];

        yield 'fractional line count' => ['line-rate="0.95" lines-covered="9.5" lines-valid="10" branch-rate="1" branches-covered="1" branches-valid="1"'];

        yield 'line rate contradicts counts' => ['line-rate="1" lines-covered="0" lines-valid="10" branch-rate="1" branches-covered="1" branches-valid="1"'];

        yield 'negative branch total' => ['line-rate="1" lines-covered="1" lines-valid="1" branch-rate="0" branches-covered="0" branches-valid="-1"'];

        yield 'covered branches exceed total' => ['line-rate="1" lines-covered="1" lines-valid="1" branch-rate="1.1" branches-covered="11" branches-valid="10"'];

        yield 'fractional branch count' => ['line-rate="1" lines-covered="1" lines-valid="1" branch-rate="0.95" branches-covered="9.5" branches-valid="10"'];

        yield 'branch rate contradicts counts' => ['line-rate="1" lines-covered="1" lines-valid="1" branch-rate="1" branches-covered="0" branches-valid="10"'];
    }
}
