<?php

declare(strict_types=1);

namespace XTwitterScraper\Extractions\ExtractionRunParams;

/**
 * Identifier for the extraction tool used to run a job.
 */
enum ToolType: string
{
    case ARTICLE_EXTRACTOR = 'article_extractor';

    case COMMUNITY_EXTRACTOR = 'community_extractor';

    case COMMUNITY_MODERATOR_EXPLORER = 'community_moderator_explorer';

    case COMMUNITY_POST_EXTRACTOR = 'community_post_extractor';

    case COMMUNITY_SEARCH = 'community_search';

    case FOLLOWER_EXPLORER = 'follower_explorer';

    case FOLLOWING_EXPLORER = 'following_explorer';

    case LIST_FOLLOWER_EXPLORER = 'list_follower_explorer';

    case LIST_MEMBER_EXTRACTOR = 'list_member_extractor';

    case LIST_POST_EXTRACTOR = 'list_post_extractor';

    case MENTION_EXTRACTOR = 'mention_extractor';

    case PEOPLE_SEARCH = 'people_search';

    case POST_EXTRACTOR = 'post_extractor';

    case QUOTE_EXTRACTOR = 'quote_extractor';

    case REPLY_EXTRACTOR = 'reply_extractor';

    case REPOST_EXTRACTOR = 'repost_extractor';

    case SPACE_EXPLORER = 'space_explorer';

    case THREAD_EXTRACTOR = 'thread_extractor';

    case TWEET_SEARCH_EXTRACTOR = 'tweet_search_extractor';

    case VERIFIED_FOLLOWER_EXPLORER = 'verified_follower_explorer';
}
