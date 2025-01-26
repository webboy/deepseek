<?php

namespace Webboy\Deepseek\Dto\Requests\CreateChatCompletion;

use Webboy\Deepseek\Dto\Requests\RequestDto;
use Webboy\Deepseek\Enums\DeepseekMessageRoleEnum;
use Webboy\Deepseek\Exceptions\DtoExceptions\MessageExceptions\InvalidRoleMessageException;

abstract class MessageDto extends RequestDto
{
    public string $role;

    /**
     * @throws InvalidRoleMessageException
     */
    public function __construct(
        string $role,
    )
    {
        if (DeepseekMessageRoleEnum::tryFrom($role) === null) {
            throw new InvalidRoleMessageException($role);
        }
        $this->role = $role;
    }

    abstract public function toArray(): array;

    // Getters
    public function getRole(): string
    {
        return $this->role;
    }
}