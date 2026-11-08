<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ShadowbanReport\Checks\Replies\Evidence\Replies;

enum Placement: string
{
    case THREAD = 'thread';

    case MORE_REPLIES = 'more_replies';

    case NOT_FOUND = 'not_found';
}
