<?php

namespace Webboy\Deepseek\Dto\Requests\CreateChatCompletion\StreamOption;

use Webboy\Deepseek\Dto\Requests\RequestDto;

class SteamOptionDto extends RequestDto
{
    public function __construct(
        public ?bool $include_usage = null,
    ){}
}