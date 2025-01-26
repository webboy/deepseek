<?php

namespace Webboy\Deepseek\Exceptions\DtoExceptions\ChatCompletionExceptions;

use Webboy\Deepseek\Exceptions\DtoExceptions\ChatCompletionException;

class InvalidFrequencyPenaltyChatCompletionException extends ChatCompletionException
{
    public function __construct(mixed $value)
    {
        $message = "Invalid frequency penalty: {$value}.";
        parent::__construct($message);
    }
}
