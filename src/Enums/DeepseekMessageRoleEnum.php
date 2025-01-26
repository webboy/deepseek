<?php

namespace Webboy\Deepseek\Enums;

enum DeepseekMessageRoleEnum: string
{
    case MESSAGE_ROLE_SYSTEM = 'system';

    case MESSAGE_ROLE_USER = 'user';

    case MESSAGE_ROLE_ASSISTANT = 'assistant';

    case MESSAGE_ROLE_TOOL = 'tool';
}
