<?php

namespace Webboy\Deepseek\Enums;

use Webboy\Deepseek\Dto\Requests\CreateChatCompletion\ResponseFormat\ResponseFormatDto;

enum DeepseekResponseFormatTypeEnum: string
{
    case TEXT = 'text';

    case JSON_OBJECT = 'json_object';

    // To object
    public function toObject(): ResponseFormatDto
    {
        return match ($this) {
            self::TEXT => new ResponseFormatDto('text'),
            self::JSON_OBJECT => new ResponseFormatDto('json_object'),
        };
    }
}
