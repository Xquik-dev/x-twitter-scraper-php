<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Extractions\ExtractionEstimateCostParams\RelationTarget;

enum Relation: string
{
    case COMMUNITY_MEMBERS = 'community_members';

    case FOLLOWERS = 'followers';

    case FOLLOWING = 'following';

    case LIST_FOLLOWERS = 'list_followers';

    case LIST_MEMBERS = 'list_members';

    case VERIFIED_FOLLOWERS = 'verified_followers';
}
