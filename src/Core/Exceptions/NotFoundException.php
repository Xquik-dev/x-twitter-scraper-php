<?php

namespace XTwitterScraper\Core\Exceptions;

class NotFoundException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'XTwitterScraper Not Found Exception';
}
