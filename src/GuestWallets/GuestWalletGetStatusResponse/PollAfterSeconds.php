<?php

declare(strict_types=1);

namespace XTwitterScraper\GuestWallets\GuestWalletGetStatusResponse;

/**
 * Polling delay while payment is pending. Null means stop.
 */
enum PollAfterSeconds: int
{
    case _2 = 2;
}
