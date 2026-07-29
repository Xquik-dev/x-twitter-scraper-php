<?php

declare(strict_types=1);

namespace XTwitterScraper\X\AccountConnectionAttempts\AccountConnectionAttemptGetResponse\XAccountConnectionChallenge;

enum Status: string
{
    case REQUIRES_EMAIL_CODE = 'requires_email_code';
}
