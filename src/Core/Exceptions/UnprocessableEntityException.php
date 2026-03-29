<?php

namespace XTwitterScraper\Core\Exceptions;

class UnprocessableEntityException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'XTwitterScraper Unprocessable Entity Exception';
}
