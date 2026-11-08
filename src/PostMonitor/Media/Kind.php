<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\PostMonitor\Media;

enum Kind: string
{
    case GIF = 'gif';

    case PHOTO = 'photo';

    case VIDEO = 'video';
}
