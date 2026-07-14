<?php

declare(strict_types=1);

namespace XTwitterScraper;

/**
 * Type of monitor event fired when account activity occurs.
 */
enum EventType: string
{
    case TWEET_NEW = 'tweet.new';

    case TWEET_REPLY = 'tweet.reply';

    case TWEET_RETWEET = 'tweet.retweet';

    case TWEET_QUOTE = 'tweet.quote';

    case TWEET_MEDIA = 'tweet.media';

    case TWEET_LINK = 'tweet.link';

    case TWEET_POLL = 'tweet.poll';

    case TWEET_MENTION = 'tweet.mention';

    case TWEET_HASHTAG = 'tweet.hashtag';

    case TWEET_LONGFORM = 'tweet.longform';

    case PROFILE_AVATAR_CHANGED = 'profile.avatar.changed';

    case PROFILE_BANNER_CHANGED = 'profile.banner.changed';

    case PROFILE_NAME_CHANGED = 'profile.name.changed';

    case PROFILE_USERNAME_CHANGED = 'profile.username.changed';

    case PROFILE_BIO_CHANGED = 'profile.bio.changed';

    case PROFILE_LOCATION_CHANGED = 'profile.location.changed';

    case PROFILE_URL_CHANGED = 'profile.url.changed';

    case PROFILE_VERIFIED_CHANGED = 'profile.verified.changed';

    case PROFILE_PROTECTED_CHANGED = 'profile.protected.changed';

    case PROFILE_PINNED_TWEET_CHANGED = 'profile.pinned_tweet.changed';

    case PROFILE_UNAVAILABLE_CHANGED = 'profile.unavailable.changed';
}
