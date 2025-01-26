<?php

namespace Webboy\Deepseek\Dto\Responses\ChatCompletion;

use Illuminate\Support\Collection;
use Webboy\Deepseek\Dto\Responses\ResponseDto;
use Webboy\Deepseek\Exceptions\DtoExceptions\ChatCompletionExceptions\InvalidFinishReasonException;
use Webboy\Deepseek\Exceptions\DtoExceptions\MessageExceptions\InvalidRoleMessageException;

class ChatCompletionResponseDto extends ResponseDto
{
    /**
     * @param string $id
     * @param string $object
     * @param int $created
     * @param string|null $model
     * @param string|null $system_fingerprint
     * @param Collection<int|ChatChoiceDto> |null $choices
     * @param UsageDto|null $usage
     */
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
            choices: collect(array_map(
                /**
                 * @throws InvalidRoleMessageException
                 * @throws InvalidFinishReasonException
                */
                fn ($choice) => ChatChoiceDto::fromArray($choice),
                $data['choices'] ?? []
            )),
            usage: UsageDto::fromArray($data['usage'] ?? []),
        );
    }

    public function __toString(): string
    {
        $output = "ChatCompletionResponseDto: " . PHP_EOL;
        foreach ($this->choices as $choice) {
            $output .= "Choice {$choice->index}:" . PHP_EOL;
            $output .= "Message: {$choice->message->content}" . PHP_EOL;
        }

        return $output;
    }
}
