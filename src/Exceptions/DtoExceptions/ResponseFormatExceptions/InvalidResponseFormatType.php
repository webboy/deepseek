<?php

namespace Webboy\Deepseek\Exceptions\DtoExceptions\ResponseFormatExceptions;

use Webboy\Deepseek\Exceptions\DtoExceptions\ResponseFormatException;

class InvalidResponseFormatType extends ResponseFormatException
{
    public function __construct(mixed $type = null)
    {
        $message = "Invalid response format type: {$type}";
        parent::__construct($message);
    }
}
