<?php

namespace Webboy\Deepseek\Dto\Responses;

use Webboy\Deepseek\Dto\BaseDto;

abstract class ResponseDto extends BaseDto
{
    public static function fromArray(array $data): static
    {
        /** @phpstan-ignore new.static */
        return new static(...$data);
    }
}
