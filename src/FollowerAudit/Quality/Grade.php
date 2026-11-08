<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\FollowerAudit\Quality;

enum Grade: string
{
    case A = 'A';

    case B = 'B';

    case C = 'C';

    case D = 'D';

    case F = 'F';
}
