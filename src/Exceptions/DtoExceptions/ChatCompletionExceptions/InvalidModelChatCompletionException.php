<?php

namespace Webboy\Deepseek\Exceptions\DtoExceptions\ChatCompletionExceptions;

use Webboy\Deepseek\Exceptions\DtoExceptions\ChatCompletionException;

class InvalidModelChatCompletionException extends ChatCompletionException
{
    public function __construct(mixed $model)
    {
        $message = "Invalid model: {$model}.";
        parent::__construct($message);
    }
}
