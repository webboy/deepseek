<?php

namespace Webboy\Deepseek\Dto\Requests\CreateChatCompletion\Message;

use Webboy\Deepseek\Dto\Requests\CreateChatCompletion\MessageDto;
use Webboy\Deepseek\Enums\DeepseekMessageRoleEnum;
use Webboy\Deepseek\Exceptions\DtoExceptions\MessageExceptions\InvalidRoleMessageException;

/**
 * Class ToolMessageDto
 * @package Webboy\Deepseek\Dto\Requests\CreateChatCompletion\Message
 */
class ToolMessageDto extends MessageDto
{
    /**
     * The contents of the tool message.
     * @var string $content
     */
    protected string $content;

    /**
     * Tool call that this message is responding to.
     * @var string $tool_call_id
     */
    protected string $tool_call_id;

    /**
     * AssistantMessageDto constructor.
     * @param string $content
     * @param string $tool_call_id
     * @throws InvalidRoleMessageException
     */
    public function __construct(string $content, string $tool_call_id)
    {
        $this->content = $content;

        parent::__construct(DeepseekMessageRoleEnum::MESSAGE_ROLE_TOOL->value);
    }

    public function toArray(): array
    {
        return [
            'role' => $this->role,
            'content' => $this->content,
            'tool_call_id' => $this->tool_call_id
        ];
    }
}
