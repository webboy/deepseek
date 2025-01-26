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
use Webboy\Deepseek\Exceptions\DtoExceptions\ChatCompletionExceptions\InvalidModelChatCompletionException;
use Webboy\Deepseek\Exceptions\DtoExceptions\MessageExceptions\InvalidRoleMessageException;

/**
 * Class CreateChatCompletionRequestDto
 */
class CreateChatCompletionRequestDto extends RequestDto
{
    // Properties

    /**
     * @var Collection<string|MessageDto> $messages
     */
    protected Collection $messages;

    /**
     * @var DeepseekAiModelsEnum $model
     */
    protected DeepseekAiModelsEnum $model;

    /**
     * @var int $frequency_penalty
     */
    protected int $frequency_penalty;

    /**
     * @var int $max_tokens
     */
    protected int $max_tokens;

    /**
     * @var int $presence_penalty
     */
    protected int $presence_penalty;

    /**
     * @var ResponseFormatDto $response_format
     */
    protected ResponseFormatDto $response_format;

    /**
     * @var string|null $stop
     */
    protected ?string $stop;

    /**
     * @var bool $stream
     */
    protected bool $stream;

    /**
     * @var Collection|null $stream_options
     */
    protected ?Collection $stream_options;

    /**
     * @var int $temperature
     */
    protected int $temperature;

    /**
     * @var int $top_p
     */
    protected int $top_p;

    /**
     * @var Collection|null $tools
     */
    protected ?Collection $tools;

    /**
     * @var string $tool_choice
     */
    protected string $tool_choice;

    /**
     * @var bool $logprobs
     */
    protected bool $logprobs;

    /**
     * @var Collection|null $top_logprobs
     */
    protected ?Collection $top_logprobs;

    /**
     * CreateChatCompletionRequestDto constructor.
     * @param SystemMessageDto|null $system_message
     * @param UserMessageDto|null $user_message
     * @param AssistantMessageDto|null $assistant_message
     * @param ToolMessageDto|null $tool_message
     * @param string|null $model
     * @param int $frequency_penalty
     * @param int $max_tokens
     * @param int $presence_penalty
     * @param ResponseFormatDto|null $response_format
     * @param string|null $stop
     * @param bool $stream
     * @param array|null $stream_options
     * @param int $temperature
     * @param int $top_p
     * @param array|null $tools
     * @param string $tool_choice
     * @param bool $logprobs
     * @param array|null $top_logprobs
     * @throws InvalidModelChatCompletionException
     */
    public function __construct(
         ?SystemMessageDto $system_message = null,
         ?UserMessageDto $user_message = null,
         ?AssistantMessageDto $assistant_message = null,
         ?ToolMessageDto $tool_message = null,
         ?string $model = 'deepseek-chat',
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

        // Set model
        $this->setModel($model);

        // Frequency penalty
        $this->setFrequencyPenalty($frequency_penalty);

        // Max tokens
        $this->setMaxTokens($max_tokens);

        // Presence penalty
        $this->setPresencePenalty($presence_penalty);

        // Response format
        $this->setResponseFormat($response_format);

        // Stop
        $this->setStop($stop);

        // Stream
        $this->setStream($stream);

        // Stream options
        $this->setStreamOptions($stream_options);

        // Temperature
        $this->setTemperature($temperature);

        // Top P
        $this->setTopP($top_p);

        // Tools
        $this->setTools($tools);

        // Tool choice
        $this->setToolChoice($tool_choice);

        // Logprobs
        $this->setLogprobs($logprobs);

        // Top logprobs
        $this->setTopLogprobs($top_logprobs);
    }

    // Setters

    /**
     * @param string $content
     * @param string|null $name
     * @return CreateChatCompletionRequestDto
     * @throws InvalidRoleMessageException
     */
    public function setSystemMessage(string $content, ?string $name = null): self
    {
        $message = new SystemMessageDto($content, $name);

        return $this->setMessage($message);
    }

    /**
     * @param string $content
     * @param string|null $name
     * @return CreateChatCompletionRequestDto
     * @throws InvalidRoleMessageException
     */
    public function setUserMessage(string $content, ?string $name = null): self
    {
        $message = new UserMessageDto($content, $name);

        return $this->setMessage($message);
    }

    /**
     * @param MessageDto|null $message
     * @return CreateChatCompletionRequestDto
     */
    private function setMessage(?MessageDto $message): self
    {
        if ($message) {
            $this->messages->put(
                $message->getRole(),
                $message
            );
        }

        return $this;
    }

    /**
     * @param string|null $model
     * @return $this
     * @throws InvalidModelChatCompletionException
     */
    public function setModel(?string $model = null): self
    {
        if ($model) {
            $model = DeepseekAiModelsEnum::tryFrom($model);

            if ($model) {
                $this->model = $model;
            } else {
                throw new InvalidModelChatCompletionException($model);
            }
        }

        return $this;
    }

    /**
     * @param int $frequency_penalty
     * @return $this
     */
    public function setFrequencyPenalty(int $frequency_penalty): self
    {
        $this->frequency_penalty = $frequency_penalty;

        return $this;
    }

    public function setMaxTokens(int $max_tokens): self
    {
        $this->max_tokens = $max_tokens;

        return $this;
    }

    public function setPresencePenalty(int $presence_penalty): self
    {
        $this->presence_penalty = $presence_penalty;

        return $this;
    }

    public function setResponseFormat(ResponseFormatDto $response_format): self
    {
        $this->response_format = $response_format;

        return $this;
    }

    public function setStop(string $stop): self
    {
        $this->stop = $stop;

        return $this;
    }

    public function setStream(bool $stream): self
    {
        $this->stream = $stream;

        return $this;
    }

    public function setStreamOptions(array $stream_options): self
    {
        $this->stream_options = collect($stream_options);

        return $this;
    }

    public function setTemperature(int $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function setTopP(int $top_p): self
    {
        $this->top_p = $top_p;

        return $this;
    }

    public function setTools(array $tools): self
    {
        $this->tools = collect($tools);

        return $this;
    }

    public function setToolChoice(string $tool_choice): self
    {
        $this->tool_choice = $tool_choice;

        return $this;
    }

    public function setLogprobs(bool $logprobs): self
    {
        $this->logprobs = $logprobs;

        return $this;
    }

    public function setTopLogprobs(array $top_logprobs): self
    {
        $this->top_logprobs = collect($top_logprobs);

        return $this;
    }

    // Getters

    /**
     * @return Collection
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    /**
     * @return DeepseekAiModelsEnum
     */
    public function getModel(): DeepseekAiModelsEnum
    {
        return $this->model;
    }

    public function getStreamOptions(): ?Collection
    {
        if ($this->stream_options->isEmpty()) {
            return null;
        }

        return $this->stream_options;
    }

    public function getTools(): ?Collection
    {
        if ($this->tools->isEmpty()) {
            return null;
        }

        return $this->tools;
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
            'model' => $this->getModel()->value,
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