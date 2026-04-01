<?php

declare(strict_types=1);

namespace XTwitterScraper\Webhooks\Webhook;

enum EventType: string
{
    case TWEET_NEW = 'tweet.new';

    case TWEET_REPLY = 'tweet.reply';

    case TWEET_RETWEET = 'tweet.retweet';

    case TWEET_QUOTE = 'tweet.quote';

    case FOLLOWER_GAINED = 'follower.gained';

    case FOLLOWER_LOST = 'follower.lost';
}
