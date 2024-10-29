<?php

declare (strict_types=1);

namespace App\Exceptions;

class AlredyAbbreviationExistsException extends \Exception
{
    protected $message = "The comment with abbreviation %s does not exist.";

    public function __construct(string $abbreviation)
    {
        parent::__construct(sprintf($this->message, $abbreviation));
    }
}