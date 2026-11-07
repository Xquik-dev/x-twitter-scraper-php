<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

namespace Tests\Extractions;

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
    public function testEveryToolTypeTakesUserAffiliates(): void
    {
        $this->assertSame(EstimateToolType::USER_AFFILIATES, EstimateToolType::from('user_affiliates'));
        $this->assertSame(JobToolType::USER_AFFILIATES, JobToolType::from('user_affiliates'));
        $this->assertSame(ListToolType::USER_AFFILIATES, ListToolType::from('user_affiliates'));
        $this->assertSame(RunToolType::USER_AFFILIATES, RunToolType::from('user_affiliates'));
    }
}
