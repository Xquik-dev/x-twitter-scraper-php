<?php

namespace XTwitterScraper\Core\Exceptions;

class RateLimitException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'XTwitterScraper Rate Limit Exception';
}
