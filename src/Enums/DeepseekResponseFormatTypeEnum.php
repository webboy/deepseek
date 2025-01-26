<?php

namespace Webboy\Deepseek\Enums;

use Webboy\Deepseek\Dto\Requests\CreateChatCompletion\ResponseFormat\ResponseFormatDto;

enum DeepseekResponseFormatTypeEnum: string
{
    case TEXT = 'text';

    case JSON_OBJECT = 'json_object';

}
