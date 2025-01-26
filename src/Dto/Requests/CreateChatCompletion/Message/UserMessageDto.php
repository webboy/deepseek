<?php

namespace Webboy\Deepseek\Dto\Requests\CreateChatCompletion\Message;

use Webboy\Deepseek\Dto\Requests\CreateChatCompletion\MessageDto;
use Webboy\Deepseek\Enums\DeepseekMessageRoleEnum;
use Webboy\Deepseek\Exceptions\DtoExceptions\MessageExceptions\InvalidRoleMessageException;

/**
 * Class UserMessageDto
 * @package Webboy\Deepseek\Dto\Requests\CreateChatCompletion\Message
 */
class UserMessageDto extends MessageDto
{
    /**
     * The contents of the user message.
     * @var string $content
     */
    protected string $content;

    /**
     * An optional name for the participant. Provides the model information to
     * differentiate between participants of the same role.
     * @var string|null $name
     */
    protected ?string $name = null;

    /**
     * UserMessageDto constructor.
     * @param string $content
     * @param string|null $name
     * @throws InvalidRoleMessageException
     */
    public function __construct(string $content, ?string $name = null)
    {
        $this->content = $content;
        $this->name = $name;
        parent::__construct(DeepseekMessageRoleEnum::MESSAGE_ROLE_SYSTEM->value);
    }

    public function toArray(): array
    {
        return [
            'role' => $this->role,
            'content' => $this->content,
            'name' => $this->name
        ];
    }
}
