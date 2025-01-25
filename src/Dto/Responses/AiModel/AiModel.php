<?php

namespace Webboy\Deepseek\Dto\Responses\AiModel;

use Webboy\Deepseek\Dto\Responses\ResponseDto;

class AiModel extends ResponseDto
{
    public function __construct(
        protected string $id,
        protected string $object,
        protected string $owned_by
    ){}
}