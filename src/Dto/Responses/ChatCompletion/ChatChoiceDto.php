<?php

namespace Webboy\Deepseek\Dto\Responses\ChatCompletion;

use Webboy\Deepseek\Dto\Responses\ResponseDto;
use Webboy\Deepseek\Enums\DeepseekFinishReasonEnum;
use Webboy\Deepseek\Exceptions\DtoExceptions\ChatCompletionExceptions\InvalidFinishReasonException;
use Webboy\Deepseek\Exceptions\DtoExceptions\MessageExceptions\InvalidRoleMessageException;

class ChatChoiceDto extends ResponseDto
{
    public DeepseekFinishReasonEnum $finish_reason;

    /**
     * @throws InvalidFinishReasonException
     */
    public function __construct(
        public int $index,
        public MessageDto $message,
        public ?string $logprobs = null,
        string $finish_reason_id = 'stop'
    ) {
        $this->finish_reason = DeepseekFinishReasonEnum::from($finish_reason_id)
            ?? throw new InvalidFinishReasonException($finish_reason_id);
    }

    /**
     * @throws InvalidFinishReasonException|InvalidRoleMessageException
     */
    public static function fromArray(array $data): static
    {
        return new self(
            index: $data['index'],
            message: MessageDto::fromArray($data['message']),
            logprobs: $data['logprobs'] ?? null,
            finish_reason_id: $data['finish_reason'],
        );
    }
}
