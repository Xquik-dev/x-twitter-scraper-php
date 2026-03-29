<?php

namespace XTwitterScraper\Core\Exceptions;

class ConflictException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'XTwitterScraper Conflict Exception';
}
