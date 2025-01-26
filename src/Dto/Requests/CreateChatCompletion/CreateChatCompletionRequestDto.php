<?php

namespace Webboy\Deepseek\Dto\Requests\CreateChatCompletion;

use Illuminate\Support\Collection;
use Webboy\Deepseek\Dto\Requests\CreateChatCompletion\Message\AssistantMessageDto;
use Webboy\Deepseek\Dto\Requests\CreateChatCompletion\Message\SystemMessageDto;
use Webboy\Deepseek\Dto\Requests\CreateChatCompletion\Message\ToolMessageDto;
use Webboy\Deepseek\Dto\Requests\CreateChatCompletion\Message\UserMessageDto;
use Webboy\Deepseek\Dto\Requests\CreateChatCompletion\ResponseFormat\ResponseFormatDto;
use Webboy\Deepseek\Dto\Requests\RequestDto;
use Webboy\Deepseek\Enums\DeepseekAiModelsEnum;
use Webboy\Deepseek\Exceptions\DtoExceptions\MessageExceptions\InvalidRoleMessageException;
use Webboy\Deepseek\Exceptions\DtoExceptions\ResponseFormatExceptions\InvalidResponseFormatType;

class CreateChatCompletionRequestDto extends RequestDto
{
    // Properties

    /**
     * @var Collection<string|MessageDto> $messages
     */
    protected Collection $messages;
    protected DeepseekAiModelsEnum $model;
    protected int $frequency_penalty;
    protected int $max_tokens;
    protected int $presence_penalty;
    protected ResponseFormatDto $response_format;
    protected ?string $stop;
    protected bool $stream;
    protected ?Collection $stream_options;
    protected int $temperature;
    protected int $top_p;
    protected ?Collection $tools;
    protected string $tool_choice;
    protected bool $logprobs;
    protected ?Collection $top_logprobs;

    public function __construct(
         ?SystemMessageDto $system_message = null,
         ?UserMessageDto $user_message = null,
         ?AssistantMessageDto $assistant_message = null,
         ?ToolMessageDto $tool_message = null,
         ?string $model = null,
         int $frequency_penalty = 0,
         int $max_tokens = 2048,
         int $presence_penalty = 0,
         ?ResponseFormatDto $response_format = null,
         ?string $stop = null,
         bool $stream = false,
         ?array $stream_options = null,
         int $temperature =1,
         int $top_p = 1,
         ?array $tools = null,
         string $tool_choice = 'none',
         bool $logprobs = false,
         ?array $top_logprobs = null
    ) {
        $this->messages = collect();

        // Set messages
        $this->setMessage($system_message);
        $this->setMessage($user_message);
        $this->setMessage($assistant_message);
        $this->setMessage($tool_message);

        $this->model = DeepseekAiModelsEnum::tryFrom($model);
        $this->frequency_penalty = $frequency_penalty;
        $this->max_tokens = $max_tokens;
        $this->presence_penalty = $presence_penalty;
        $this->response_format = $response_format;
        $this->stop = $stop;
        $this->stream = $stream;
        $this->stream_options = collect($stream_options);
        $this->temperature = $temperature;
        $this->top_p = $top_p;
        $this->tools = collect($tools);
        $this->tool_choice = $tool_choice;
        $this->logprobs = $logprobs;
        $this->top_logprobs = collect($top_logprobs);
    }

    // Setters

    /**
     * @throws InvalidRoleMessageException
     */
    public function setSystemMessage(string $content, ?string $name = null): CreateChatCompletionRequestDto
    {
        $message = new SystemMessageDto($content, $name);

        return $this->setMessage($message);
    }

    /**
     * @throws InvalidRoleMessageException
     */
    public function setUserMessage(string $content, ?string $name = null): CreateChatCompletionRequestDto
    {
        $message = new UserMessageDto($content, $name);

        return $this->setMessage($message);
    }

    private function setMessage(?MessageDto $message): CreateChatCompletionRequestDto
    {
        if ($message) {
            $this->messages->put(
                $message->getRole(),
                $message
            );
        }

        return $this;
    }

    public function setModel(string $model): CreateChatCompletionRequestDto
    {
        $this->model = DeepseekAiModelsEnum::tryFrom($model);

        return $this;
    }

    // Getters
    public function getMessages(): Collection
    {
        return $this->messages;
    }
    public function getModel(): DeepseekAiModelsEnum
    {
        return $this->model;
    }
    public function getFrequencyPenalty(): int
    {
        return $this->frequency_penalty;
    }
    public function getMaxTokens(): int
    {
        return $this->max_tokens;
    }
    public function getPresencePenalty(): int
    {
        return $this->presence_penalty;
    }
    public function getResponseFormat(): ResponseFormatDto
    {
        return $this->response_format;
    }
    public function getStop(): ?string
    {
        return $this->stop;
    }
    public function getStream(): bool
    {
        return $this->stream;
    }
    public function getStreamOptions(): ?Collection
    {
        if ($this->stream_options->isEmpty()) {
            return null;
        }

        return $this->stream_options;
    }
    public function getTemperature(): int
    {
        return $this->temperature;
    }
    public function getTopP(): int
    {
        return $this->top_p;
    }
    public function getTools(): ?Collection
    {
        if ($this->tools->isEmpty()) {
            return null;
        }

        return $this->tools;
    }
    public function getToolChoice(): string
    {
        return $this->tool_choice;
    }
    public function getLogprobs(): bool
    {
        return $this->logprobs;
    }
    public function getTopLogprobs(): ?Collection
    {
        if ($this->top_logprobs->isEmpty()) {
            return null;
        }

        return $this->top_logprobs;
    }

    // Methods
    public function toArray(): array
    {
        $messages = [];
        foreach ($this->messages as $message) {
            $messages[] = $message->toArray();
        }

        return [
            'messages' => $messages,
            'model' => $this->model->value,
            'frequency_penalty' => $this->frequency_penalty,
            'max_tokens' => $this->max_tokens,
            'presence_penalty' => $this->presence_penalty,
            'response_format' => $this->response_format->toArray(),
            'stop' => $this->stop,
            'stream' => $this->stream,
            'stream_options' => $this->getStreamOptions(),
            'temperature' => $this->temperature,
            'top_p' => $this->top_p,
            'tools' => $this->getTools(),
            'tool_choice' => $this->tool_choice,
            'logprobs' => $this->logprobs,
            'top_logprobs' => $this->getTopLogprobs()
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
/**
 * {
 * "messages": [
 * {
 * "content": "You are a helpful assistant",
 * "role": "system"
 * },
 * {
 * "content": "Hi",
 * "role": "user"
 * }
 * ],
 * "model": "deepseek-chat",
 * "frequency_penalty": 0,
 * "max_tokens": 2048,
 * "presence_penalty": 0,
 * "response_format": {
 * "type": "text"
 * },
 * "stop": null,
 * "stream": false,
 * "stream_options": null,
 * "temperature": 1,
 * "top_p": 1,
 * "tools": null,
 * "tool_choice": "none",
 * "logprobs": false,
 * "top_logprobs": null
 * }
 */