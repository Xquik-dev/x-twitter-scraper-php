<?php

declare(strict_types=1);

namespace XTwitterScraper\Error;

enum Error: string
{
    case INTERNAL_ERROR = 'internal_error';

    case INVALID_FORMAT = 'invalid_format';

    case INVALID_ID = 'invalid_id';

    case INVALID_INPUT = 'invalid_input';

    case INVALID_PARAMS = 'invalid_params';

    case INVALID_TOOL_TYPE = 'invalid_tool_type';

    case INVALID_TWEET_ID = 'invalid_tweet_id';

    case INVALID_TWEET_URL = 'invalid_tweet_url';

    case INVALID_USERNAME = 'invalid_username';

    case MISSING_PARAMS = 'missing_params';

    case MISSING_QUERY = 'missing_query';

    case MONITOR_ALREADY_EXISTS = 'monitor_already_exists';

    case MONITOR_LIMIT_REACHED = 'monitor_limit_reached';

    case NO_SUBSCRIPTION = 'no_subscription';

    case NOT_FOUND = 'not_found';

    case STREAM_REGISTRATION_FAILED = 'stream_registration_failed';

    case SUBSCRIPTION_INACTIVE = 'subscription_inactive';

    case TWEET_NOT_FOUND = 'tweet_not_found';

    case UNAUTHENTICATED = 'unauthenticated';

    case USAGE_LIMIT_REACHED = 'usage_limit_reached';

    case USER_NOT_FOUND = 'user_not_found';

    case WEBHOOK_INACTIVE = 'webhook_inactive';

    case X_API_RATE_LIMITED = 'x_api_rate_limited';

    case X_API_UNAVAILABLE = 'x_api_unavailable';

    case X_API_UNAUTHORIZED = 'x_api_unauthorized';
}
