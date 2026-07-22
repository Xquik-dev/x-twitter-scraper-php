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

    case BODY_TOO_LARGE = 'body_too_large';

    case CHECKOUT_UNAVAILABLE = 'checkout_unavailable';

    case CONNECTION_CHALLENGE_EXPIRED = 'connection_challenge_expired';

    case CONNECTION_CHALLENGE_INACTIVE = 'connection_challenge_inactive';

    case DRAFT_NOT_FOUND = 'draft_not_found';

    case FAVORITERS_UNAVAILABLE = 'favoriters_unavailable';

    case FORBIDDEN = 'forbidden';

    case GUEST_WALLET_UNAVAILABLE = 'guest_wallet_unavailable';

    case GUEST_WALLETS_DISABLED = 'guest_wallets_disabled';

    case GUEST_WALLETS_UNAVAILABLE = 'guest_wallets_unavailable';

    case IDEMPOTENCY_CONFLICT = 'idempotency_conflict';

    case IDEMPOTENCY_KEY_CONFLICT = 'idempotency_key_conflict';

    case INVALID_COMMUNITY_ID = 'invalid_community_id';

    case INVALID_IDEMPOTENCY_KEY = 'invalid_idempotency_key';

    case INVALID_LIST_ID = 'invalid_list_id';

    case INVALID_PAYMENT_AMOUNT = 'invalid_payment_amount';

    case INVALID_RANGE = 'invalid_range';

    case LOGIN_RATE_LIMITED = 'login_rate_limited';

    case MISSING_IDEMPOTENCY_KEY = 'missing_idempotency_key';

    case MISSING_IDS = 'missing_ids';

    case NO_CACHED_STYLE = 'no_cached_style';

    case PASSKEY_REQUIRED = 'passkey_required';

    case RATE_LIMITED = 'rate_limited';

    case READ_REQUEST_TIMEOUT = 'read_request_timeout';

    case REPLIES_INCOMPLETE = 'replies_incomplete';

    case SUPPORT_MEDIA_RATE_LIMIT = 'support_media_rate_limit';

    case SUPPORT_REQUEST_RATE_LIMIT = 'support_request_rate_limit';

    case TOO_MANY_IDS = 'too_many_ids';

    case UNKNOWN_FIELD = 'unknown_field';

    case UNSUPPORTED_MEDIA_TYPE = 'unsupported_media_type';

    case WEBHOOK_INACTIVE = 'webhook_inactive';

    case WRITE_TRACKING_UNAVAILABLE = 'write_tracking_unavailable';

    case X_WRITE_UNCONFIRMED = 'x_write_unconfirmed';

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
