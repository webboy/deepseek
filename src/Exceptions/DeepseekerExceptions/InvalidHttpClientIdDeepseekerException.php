<?php

namespace Webboy\Deepseek\Exceptions\DeepseekerExceptions;

use Webboy\Deepseek\Exceptions\DeepseekException;

class InvalidHttpClientIdDeepseekerException extends DeepseekException
{
    public function __construct(mixed $clientId)
    {
        $message = "Invalid HTTP client ID: {$clientId}.";
        parent::__construct($message);
    }
}
