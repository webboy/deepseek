<?php

namespace Webboy\Deepseek\Dto\Requests\CreateChatCompletion\Message;

use Webboy\Deepseek\Dto\Requests\CreateChatCompletion\MessageDto;
use Webboy\Deepseek\Enums\DeepseekMessageRoleEnum;
use Webboy\Deepseek\Exceptions\DtoExceptions\MessageExceptions\InvalidRoleMessageException;

/**
 * Class AssistantMessageDto
 * @package Webboy\Deepseek\Dto\Requests\CreateChatCompletion\Message
 */
class AssistantMessageDto extends MessageDto
{
    /**
     * The contents of the assistant message.
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
     * (Beta) Set this to true to force the model to start its answer by the content of the supplied prefix in this
     * assistant message. You must set base_url="https://api.deepseek.com/beta" to use this feature.
     * @var bool $prefix
     */
    protected bool $prefix = false;

    /**
     * (Beta) Used for the deepseek-reasoner model in the Chat Prefix Completion feature as the input for the CoT
     * in the last assistant message. When using this feature, the prefix parameter must be set to true.
     * @var string|null $reasoning_content
     */
    protected ?string $reasoning_content = null;

    /**
     * AssistantMessageDto constructor.
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
            'name' => $this->name,
            'prefix' => $this->prefix,
            'reasoning_content' => $this->reasoning_content
        ];
    }
}
