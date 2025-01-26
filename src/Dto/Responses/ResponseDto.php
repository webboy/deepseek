<?php

namespace Webboy\Deepseek\Dto\Responses;

use Webboy\Deepseek\Dto\BaseDto;

abstract class ResponseDto extends BaseDto
{
    public static function fromArray(array $data): static
    {
        return new static(...$data);
    }
}
