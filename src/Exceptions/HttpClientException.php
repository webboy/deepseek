<?php

namespace Webboy\Deepseek\Exceptions;

use Exception;
use Webboy\Deepseek\Abstractions\DeepseekException;

class HttpClientException extends DeepseekException
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}