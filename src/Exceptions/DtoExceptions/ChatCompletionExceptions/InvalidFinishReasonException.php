<?php

namespace Webboy\Deepseek\Exceptions\DtoExceptions\ChatCompletionExceptions;

use Webboy\Deepseek\Exceptions\DtoExceptions\ChatCompletionException;

class InvalidFinishReasonException extends ChatCompletionException
{
    public function __construct(mixed $value)
    {
        $message = "Invalid finish reason id: {$value}.";
        parent::__construct($message);
    }
}
