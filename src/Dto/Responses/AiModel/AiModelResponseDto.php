<?php

namespace Webboy\Deepseek\Dto\Responses\AiModel;

use Webboy\Deepseek\Dto\Responses\ResponseDto;

final class AiModelResponseDto extends ResponseDto
{
    public function __construct(
        public string $id,
        public string $object,
        public string $owned_by
    ) {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            id: $data['id'],
            object: $data['object'],
            owned_by: $data['owned_by']
        );
    }
}
