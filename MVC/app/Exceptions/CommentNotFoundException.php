<?php

declare (strict_types=1);

namespace App\Exceptions;

use Exception;

class CommentNotFoundException extends Exception
{
    protected $message = 'Comment not found or could not be deleted';

    public function __construct()
    {
        parent::__construct($this->message);
    }
}
