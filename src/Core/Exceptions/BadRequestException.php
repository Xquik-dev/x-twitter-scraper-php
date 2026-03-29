<?php

namespace XTwitterScraper\Core\Exceptions;

class BadRequestException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'XTwitterScraper Bad Request Exception';
}
