<?php

declare (strict_types=1);

namespace App\Exceptions;

class PostNotFoundException extends \Exception
{
    protected $message = "The post with ID %s does not exist.";

    public function __construct(int $id)
    {
        parent::__construct(sprintf($this->message, $id));
    }
}