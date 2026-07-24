<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Compose\ComposeCreateParams;

/**
 * Planned media type.
 */
enum MediaType: string
{
    case PHOTO = 'photo';

    case VIDEO = 'video';

    case NONE = 'none';
}
