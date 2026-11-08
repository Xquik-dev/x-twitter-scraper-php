<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ShadowbanReport;

enum Overall: string
{
    case CLEAR = 'clear';

    case LIMITED = 'limited';

    case UNCLEAR = 'unclear';

    case SUSPENDED = 'suspended';
}
