<?php

namespace Webboy\Deepseek\Dto\Responses\ChatCompletion;

use Webboy\Deepseek\Dto\Responses\ResponseDto;

class PromptTokenDetailsDto extends ResponseDto
{
    public function __construct(
        protected int $cached_tokens
    ){}
}