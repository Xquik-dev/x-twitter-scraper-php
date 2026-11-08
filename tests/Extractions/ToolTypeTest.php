<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

namespace Tests\Extractions;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use XTwitterScraper\Extractions\ExtractionEstimateCostParams\ToolType as EstimateToolType;
use XTwitterScraper\Extractions\ExtractionJob\ToolType as JobToolType;
use XTwitterScraper\Extractions\ExtractionListParams\ToolType as ListToolType;
use XTwitterScraper\Extractions\ExtractionRunParams\ToolType as RunToolType;

/**
 * @internal
 */
final class ToolTypeTest extends TestCase
{
    #[Test]
    #[DataProvider('affiliates')]
    public function testEveryToolTypeTakesUserAffiliates(string $value): void
    {
        $this->assertSame(EstimateToolType::USER_AFFILIATES, EstimateToolType::from($value));
        $this->assertSame(JobToolType::USER_AFFILIATES, JobToolType::from($value));
        $this->assertSame(ListToolType::USER_AFFILIATES, ListToolType::from($value));
        $this->assertSame(RunToolType::USER_AFFILIATES, RunToolType::from($value));
    }

    /**
     * @return list<array{string}>
     */
    public static function affiliates(): array
    {
        return [['user_affiliates']];
    }
}
