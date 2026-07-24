<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\TweetMedia;

enum Type: string
{
    case PHOTO = 'photo';

    case VIDEO = 'video';

    case ANIMATED_GIF = 'animated_gif';
}
