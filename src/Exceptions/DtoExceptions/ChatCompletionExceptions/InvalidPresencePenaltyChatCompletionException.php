<?php

namespace Webboy\Deepseek\Exceptions\DtoExceptions\ChatCompletionExceptions;

use Webboy\Deepseek\Exceptions\DtoExceptions\ChatCompletionException;

class InvalidPresencePenaltyChatCompletionException extends ChatCompletionException
{
    public function __construct(mixed $value)
    {
        $message = "Invalid presence penalty: {$value}.";
        parent::__construct($message);
    }
}
