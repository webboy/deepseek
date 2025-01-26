<?php

namespace Webboy\Deepseek\Dto\Responses\ChatCompletion;

use Illuminate\Support\Collection;
use Webboy\Deepseek\Dto\Responses\ResponseDto;

class ChatCompletionResponseDto extends ResponseDto
{
    public function __construct(
        public string $id,
        public string $object = 'chat.completion',
        public int $created = 0,
        public ?string $model = null,
        public ?string $system_fingerprint = null,
        public ?Collection $choices = null,
        public ?UsageDto $usage = null,
    ) {
    }

    public static function fromArray(array $data): static
    {
        return new self(
            id: $data['id'],
            object: $data['object'],
            created: $data['created'],
            model: $data['model'] ?? null,
            system_fingerprint: $data['system_fingerprint'] ?? null,
            choices: collect($data['choices'] ?? []),
            usage: UsageDto::fromArray($data['usage'] ?? []),
        );
    }
}
