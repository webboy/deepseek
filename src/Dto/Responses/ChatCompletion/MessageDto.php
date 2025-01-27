<?php

namespace Webboy\Deepseek\Dto\Responses\ChatCompletion;

use Webboy\Deepseek\Dto\Responses\ResponseDto;
use Webboy\Deepseek\Enums\DeepseekMessageRoleEnum;
use Webboy\Deepseek\Exceptions\DtoExceptions\MessageExceptions\InvalidRoleMessageException;

final class MessageDto extends ResponseDto
{
    public DeepseekMessageRoleEnum $role;

    /**
     * @throws InvalidRoleMessageException
     */
    public function __construct(
        string $roleIdentifier,
        public string $content,
    ) {
        $this->role = DeepseekMessageRoleEnum::from($roleIdentifier) ?? throw new InvalidRoleMessageException($roleIdentifier);
    }

    /**
     * @throws InvalidRoleMessageException
     */
    public static function fromArray(array $data): static
    {
        return new self(
            roleIdentifier: $data['role'],
            content: $data['content'],
        );
    }
}
