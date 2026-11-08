<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\XGetArticleResponse\Article\Content;

enum MediaType: string
{
    case IMAGE = 'image';

    case VIDEO = 'video';

    case GIF = 'gif';
}
