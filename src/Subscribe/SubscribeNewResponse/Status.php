<?php

declare(strict_types=1);

namespace XTwitterScraper\Subscribe\SubscribeNewResponse;

enum Status: string
{
    case CHECKOUT_CREATED = 'checkout_created';

    case ALREADY_SUBSCRIBED = 'already_subscribed';

    case PAYMENT_ISSUE = 'payment_issue';
}
