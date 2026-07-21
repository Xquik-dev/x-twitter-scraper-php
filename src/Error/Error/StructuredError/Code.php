<?php

declare(strict_types=1);

namespace XTwitterScraper\Error\Error\StructuredError;

enum Code: string
{
    case INTERNAL_ERROR = 'internal_error';

    case ACCOUNT_ALREADY_CONNECTED = 'account_already_connected';

    case ACCOUNT_NEEDS_REAUTH = 'account_needs_reauth';

    case ACCOUNT_NOT_FOUND = 'account_not_found';

    case ACCOUNT_REQUIRED = 'account_required';

    case ACCOUNT_RESTRICTED = 'account_restricted';

    case API_KEY_LIMIT_REACHED = 'api_key_limit_reached';

    case ARTICLE_NOT_FOUND = 'article_not_found';

    case DM_NOT_PERMITTED = 'dm_not_permitted';

    case INVALID_FORMAT = 'invalid_format';

    case INVALID_ID = 'invalid_id';

    case INVALID_INPUT = 'invalid_input';

    case INVALID_PARAMS = 'invalid_params';

    case INVALID_TOOL_TYPE = 'invalid_tool_type';

    case INVALID_TWEET_ID = 'invalid_tweet_id';

    case INVALID_TWEET_URL = 'invalid_tweet_url';

    case INVALID_USER_ID = 'invalid_user_id';

    case INVALID_USER_IDS = 'invalid_user_ids';

    case INVALID_USERNAME = 'invalid_username';

    case INVALID_JSON = 'invalid_json';

    case INSUFFICIENT_CREDITS = 'insufficient_credits';

    case LOGIN_COOLDOWN = 'login_cooldown';

    case LOGIN_FAILED = 'login_failed';

    case MEDIA_DOWNLOAD_FAILED = 'media_download_failed';

    case MISSING_PARAMS = 'missing_params';

    case MISSING_QUERY = 'missing_query';

    case MONITOR_ALREADY_EXISTS = 'monitor_already_exists';

    case NO_MEDIA = 'no_media';

    case NO_CREDITS = 'no_credits';

    case NO_SUBSCRIPTION = 'no_subscription';

    case NOT_FOUND = 'not_found';

    case PAYMENT_FAILED = 'payment_failed';

    case RATE_LIMIT_EXCEEDED = 'rate_limit_exceeded';

    case SERVICE_UNAVAILABLE = 'service_unavailable';

    case STYLE_NOT_FOUND = 'style_not_found';

    case SUBSCRIPTION_INACTIVE = 'subscription_inactive';

    case TWEET_NOT_FOUND = 'tweet_not_found';

    case UNAUTHENTICATED = 'unauthenticated';

    case UNSUPPORTED_FIELD = 'unsupported_field';

    case USER_NOT_FOUND = 'user_not_found';

    case X_ACCOUNT_FEATURE_REQUIRED = 'x_account_feature_required';

    case X_ACCOUNT_PROTECTED = 'x_account_protected';

    case X_ACCOUNT_SUSPENDED = 'x_account_suspended';

    case X_API_RATE_LIMITED = 'x_api_rate_limited';

    case X_API_UNAVAILABLE = 'x_api_unavailable';

    case X_API_UNAUTHORIZED = 'x_api_unauthorized';

    case X_AUTH_FAILURE = 'x_auth_failure';

    case X_CONTENT_TOO_LONG = 'x_content_too_long';

    case X_DAILY_LIMIT = 'x_daily_limit';

    case X_DM_NOT_ALLOWED = 'x_dm_not_allowed';

    case X_DUPLICATE_ACTION = 'x_duplicate_action';

    case X_LOGIN_AUTH_FAILED = 'x_login_auth_failed';

    case X_LOGIN_CHALLENGE = 'x_login_challenge';

    case X_LOGIN_DENIED = 'x_login_denied';

    case X_LOGIN_FAILED = 'x_login_failed';

    case X_LOGIN_PROXY_ERROR = 'x_login_proxy_error';

    case X_LOGIN_RATE_LIMITED = 'x_login_rate_limited';

    case X_LOGIN_SERVICE_UNAVAILABLE = 'x_login_service_unavailable';

    case X_LOGIN_SUSPENDED = 'x_login_suspended';

    case X_RATE_LIMITED = 'x_rate_limited';

    case X_REJECTED = 'x_rejected';

    case X_TARGET_NOT_FOUND = 'x_target_not_found';

    case X_TRANSIENT_ERROR = 'x_transient_error';

    case X_USER_LOOKUP_FAILED = 'x_user_lookup_failed';

    case X_WRITE_AMBIGUOUS = 'x_write_ambiguous';

    case X_WRITE_FAILED = 'x_write_failed';
}
