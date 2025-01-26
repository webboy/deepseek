<?php

namespace Webboy\Deepseek\Dto\Responses\AiModel;

use Webboy\Deepseek\Dto\Responses\ResponseDto;

class AiModelListResponseDto extends ResponseDto
{
    public function __construct(
        protected string $object = 'list',
        protected array $data = []
    ){}

    public static function fromArray(array $data): static
    {
        return new static(
            data: array_map(fn($item) => AiModelResponseDto::fromArray($item), $data['data'])
        );
    }
}