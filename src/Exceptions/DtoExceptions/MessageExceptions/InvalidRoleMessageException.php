<?php

namespace Webboy\Deepseek\Exceptions\DtoExceptions\MessageExceptions;

use Webboy\Deepseek\Exceptions\DtoExceptions\MessageException;

class InvalidRoleMessageException extends MessageException
{
    public function __construct(mixed $role = null)
    {
        $message = "Invalid message role: {$role}";

        parent::__construct($message);
    }
}