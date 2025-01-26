<?php

namespace Webboy\Deepseek\Dto\Requests\CreateChatCompletion\ResponseFormat;

use Webboy\Deepseek\Dto\Requests\RequestDto;
use Webboy\Deepseek\Enums\DeepseekResponseFormatTypeEnum;
use Webboy\Deepseek\Exceptions\DtoExceptions\ResponseFormatExceptions\InvalidResponseFormatType;

class ResponseFormatDto extends RequestDto
{
    /**
     * @throws InvalidResponseFormatType
     */
    public function __construct(
        protected string $type
    ) {
        if (DeepseekResponseFormatTypeEnum::tryFrom($type) === null) {
            throw new InvalidResponseFormatType($type);
        }
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
        ];
    }
}
