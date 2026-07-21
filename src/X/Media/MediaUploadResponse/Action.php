<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Media\MediaUploadResponse;

enum Action: string
{
    case CREATE_TWEET = 'create_tweet';

    case DELETE_TWEET = 'delete_tweet';

    case LIKE = 'like';

    case UNLIKE = 'unlike';

    case RETWEET = 'retweet';

    case UNRETWEET = 'unretweet';

    case FOLLOW = 'follow';

    case UNFOLLOW = 'unfollow';

    case REMOVE_FOLLOWER = 'remove_follower';

    case SEND_DM = 'send_dm';

    case UPLOAD_MEDIA = 'upload_media';

    case UPDATE_PROFILE = 'update_profile';

    case UPDATE_AVATAR = 'update_avatar';

    case UPDATE_BANNER = 'update_banner';

    case CREATE_COMMUNITY = 'create_community';

    case DELETE_COMMUNITY = 'delete_community';

    case JOIN_COMMUNITY = 'join_community';

    case LEAVE_COMMUNITY = 'leave_community';
}
