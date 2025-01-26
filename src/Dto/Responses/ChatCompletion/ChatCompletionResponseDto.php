<?php

namespace Webboy\Deepseek\Dto\Responses\ChatCompletion;

use Illuminate\Support\Collection;
use Webboy\Deepseek\Dto\Responses\ResponseDto;

class ChatCompletionResponseDto extends ResponseDto
{
    public function __construct(
        protected string $id,
        protected string $object = 'chat.completion',
        protected int $created = 0,
        protected ?string $model = null,
        protected ?string $system_fingerprint = null,
        protected ?Collection $chat_choices,
        protected ?UsageDto $usage = null,
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
            chat_choices: collect($data['choices'] ?? []),
            usage: UsageDto::fromArray($data['usage'] ?? []),
        );
    }
}
