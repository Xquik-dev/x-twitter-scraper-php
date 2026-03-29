<?php

namespace XTwitterScraper\Core\Exceptions;

class AuthenticationException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'XTwitterScraper Authentication Exception';
}
