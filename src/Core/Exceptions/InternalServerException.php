<?php

namespace XTwitterScraper\Core\Exceptions;

class InternalServerException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'XTwitterScraper Internal Server Exception';
}
