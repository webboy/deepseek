<?php

namespace Webboy\Deepseek\Endpoints\CreateChatCompletion;

use Illuminate\Support\Collection;
use Webboy\Deepseek\DeepseekClient;
use Webboy\Deepseek\Dto\Requests\CreateChatCompletion\Message\AssistantMessageDto;
use Webboy\Deepseek\Dto\Requests\CreateChatCompletion\Message\SystemMessageDto;
use Webboy\Deepseek\Dto\Requests\CreateChatCompletion\Message\ToolMessageDto;
use Webboy\Deepseek\Dto\Requests\CreateChatCompletion\Message\UserMessageDto;
use Webboy\Deepseek\Dto\Requests\CreateChatCompletion\MessageDto;
use Webboy\Deepseek\Dto\Requests\CreateChatCompletion\ResponseFormat\ResponseFormatDto;
use Webboy\Deepseek\Dto\Responses\ChatCompletion\ChatCompletionResponseDto;
use Webboy\Deepseek\Endpoints\DeepseekEndpoint;
use Webboy\Deepseek\Enums\DeepseekAiModelsEnum;
use Webboy\Deepseek\Exceptions\DtoExceptions\ChatCompletionExceptions\InvalidFrequencyPenaltyChatCompletionException;
use Webboy\Deepseek\Exceptions\DtoExceptions\ChatCompletionExceptions\InvalidModelChatCompletionException;
use Webboy\Deepseek\Exceptions\DtoExceptions\MessageExceptions\InvalidRoleMessageException;
use Webboy\Deepseek\Exceptions\DtoExceptions\ResponseFormatExceptions\InvalidResponseFormatType;

class CreateChatCompletionDeepseekEndpoint extends DeepseekEndpoint
{
    /**
     * @var Collection<string|MessageDto> Collection of messages in the conversation.
     */
    protected Collection $messages;

    /**
     * @var DeepseekAiModelsEnum The specific AI model to use for the chat completion.
     */
    protected DeepseekAiModelsEnum $model;

    /**
     * @var int Frequency penalty to discourage repetitive responses. Ranges from -2 to 2.
     */
    protected int $frequency_penalty;

    /**
     * @var int Maximum tokens allowed in the response. Default is 4096.
     */
    protected int $max_tokens;

    /**
     * @var int Presence penalty to encourage exploring new topics. Ranges from -2 to 2.
     */
    protected int $presence_penalty;

    /**
     * @var ResponseFormatDto Output format of the model's response (e.g., JSON format).
     */
    protected ResponseFormatDto $response_format;

    /**
     * @var string|null A specific "stop" string to end generation, or null for no stop condition.
     */
    protected ?string $stop;

    /**
     * @var bool Whether to stream the chat completion response in real-time.
     */
    protected bool $stream;

    /**
     * @var Collection|null Additional options for streaming responses.
     */
    protected ?Collection $stream_options;

    /**
     * @var int Temperature setting for randomness in generated responses. Ranges from 0 to 2.
     */
    protected int $temperature;

    /**
     * @var int Top-p sampling value to control diversity in text generation. Default is 1.
     */
    protected int $top_p;

    /**
     * @var Collection|null List of optional tools for the system to use during chat completion.
     */
    protected ?Collection $tools;

    /**
     * @var string Choice of a specific tool to use. Default is "none".
     */
    protected string $tool_choice;

    /**
     * @var bool Whether to log probabilities of tokens in the generated text.
     */
    protected bool $logprobs;

    /**
     * @var Collection|null Probabilities of top alternative tokens for each generated token.
     */
    protected ?Collection $top_logprobs;

    /**
     * @throws InvalidModelChatCompletionException
     * @throws InvalidFrequencyPenaltyChatCompletionException
     * @throws InvalidResponseFormatType
     */
    public function __construct(
        DeepseekClient $deep_seek_client,
        ?SystemMessageDto $system_message = null,
        ?UserMessageDto $user_message = null,
        ?AssistantMessageDto $assistant_message = null,
        ?ToolMessageDto $tool_message = null,
        ?string $modelId = 'deepseek-chat',
        int $frequency_penalty = 0,
        int $max_tokens = 4096,
        int $presence_penalty = 0,
        string $response_format_id = 'text',
        ?string $stop = null,
        bool $stream = false,
        ?array $stream_options = null,
        int $temperature = 1,
        int $top_p = 1,
        ?array $tools = null,
        string $tool_choice = 'none',
        bool $logprobs = false,
        ?array $top_logprobs = null
    ){
        parent::__construct($deep_seek_client);

        $this->messages = collect();

        // Set messages
        $this->setMessage($system_message);
        $this->setMessage($user_message);
        $this->setMessage($assistant_message);
        $this->setMessage($tool_message);

        // Set model
        $this->setModel($modelId);

        // Frequency penalty
        $this->setFrequencyPenalty($frequency_penalty);

        // Max tokens
        $this->setMaxTokens($max_tokens);

        // Presence penalty
        $this->setPresencePenalty($presence_penalty);

        // Response format
        $this->setResponseFormat($response_format_id);

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
     * @return CreateChatCompletionDeepseekEndpoint
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
     * @return CreateChatCompletionDeepseekEndpoint
     * @throws InvalidRoleMessageException
     */
    public function setUserMessage(string $content, ?string $name = null): self
    {
        $message = new UserMessageDto($content, $name);

        return $this->setMessage($message);
    }

    /**
     * @param MessageDto|null $message
     * @return CreateChatCompletionDeepseekEndpoint
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
     * @throws InvalidFrequencyPenaltyChatCompletionException
     */
    public function setFrequencyPenalty(int $frequency_penalty): self
    {
        if ($frequency_penalty >= -2 && $frequency_penalty <= 2) {
            $this->frequency_penalty = $frequency_penalty;
            return $this;
        }

        throw new InvalidFrequencyPenaltyChatCompletionException($frequency_penalty);
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

    /**
     * @throws InvalidResponseFormatType
     */
    public function setResponseFormat(string $response_format): self
    {
        $this->response_format = new ResponseFormatDto($response_format);

        return $this;
    }

    public function setStop(?string $stop = null): self
    {
        $this->stop = $stop;

        return $this;
    }

    public function setStream(bool $stream): self
    {
        $this->stream = $stream;

        return $this;
    }

    public function setStreamOptions(?array $stream_options = []): self
    {
        $this->stream_options = collect($stream_options);

        return $this;
    }

    public function setTemperature(int $temperature = 1): self
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function setTopP(int $top_p): self
    {
        $this->top_p = $top_p;

        return $this;
    }

    public function setTools(?array $tools = []): self
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

    public function setTopLogprobs(?array $top_logprobs = []): self
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

    /**
     * @return ChatCompletionResponseDto The response from the Deepseek API.
     */
    public function call(): ChatCompletionResponseDto
    {
        $response = $this
            ->getHttpClient()
            ->request('POST', 'chat/completions', [], $this->toArray());


        return ChatCompletionResponseDto::fromArray($response);
    }
}