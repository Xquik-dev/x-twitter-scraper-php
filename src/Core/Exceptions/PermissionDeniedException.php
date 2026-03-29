<?php

namespace XTwitterScraper\Core\Exceptions;

class PermissionDeniedException extends APIStatusException
{
    /** @var string */
    protected const DESC = 'XTwitterScraper Permission Denied Exception';
}
