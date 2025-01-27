<?php

namespace Webboy\Deepseek\Dto\Responses\AiModel;

use Illuminate\Support\Collection;
use Webboy\Deepseek\Dto\Responses\ResponseDto;

final class AiModelListResponseDto extends ResponseDto
{
    public function __construct(
        public string $object = 'list',
        public ?Collection $data = null
    ) {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            object: $data['object'],
            data: collect(array_map(fn ($item) => AiModelResponseDto::fromArray($item), $data['data']))
        );
    }
}
