<?php

namespace Tests\Endpoints;

use Illuminate\Support\Collection;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Webboy\Deepseek\Dto\Requests\CreateChatCompletion\Message\SystemMessageDto;
use Webboy\Deepseek\Dto\Requests\CreateChatCompletion\Message\UserMessageDto;
use Webboy\Deepseek\Dto\Requests\CreateChatCompletion\StreamOption\SteamOptionDto;
use Webboy\Deepseek\Dto\Responses\ChatCompletion\ChatChoiceDto;
use Webboy\Deepseek\Dto\Responses\ChatCompletion\ChatCompletionResponseDto;
use Webboy\Deepseek\Dto\Responses\ChatCompletion\MessageDto;
use Webboy\Deepseek\Endpoints\CreateChatCompletion\CreateChatCompletionDeepseekEndpoint;
use Webboy\Deepseek\Enums\DeepseekMessageRoleEnum;
use Webboy\Deepseek\Exceptions\DtoExceptions\ChatCompletionExceptions\InvalidFrequencyPenaltyChatCompletionException;
use Webboy\Deepseek\Exceptions\DtoExceptions\ChatCompletionExceptions\InvalidModelChatCompletionException;
use Webboy\Deepseek\Exceptions\DtoExceptions\ChatCompletionExceptions\InvalidPresencePenaltyChatCompletionException;
use Webboy\Deepseek\Exceptions\DtoExceptions\MessageExceptions\InvalidRoleMessageException;
use Webboy\Deepseek\Exceptions\DtoExceptions\ResponseFormatExceptions\InvalidResponseFormatType;

class CreateChatCompletionEndpointTest extends EndpointTestBase
{
    public function getSuccessJson(): string
    {
        return '{
                  "id": "22eea2b7-dd59-4c47-a0c2-21a7887eb92b",
                  "object": "chat.completion",
                  "created": 1737913652,
                  "model": "deepseek-chat",
                  "choices": [
                    {
                      "index": 0,
                      "message": {
                        "role": "assistant",
                        "content": "Hello! How can I assist you today? 😊"
                      },
                      "logprobs": null,
                      "finish_reason": "stop"
                    }
                  ],
                  "usage": {
                    "prompt_tokens": 9,
                    "completion_tokens": 11,
                    "total_tokens": 20,
                    "prompt_tokens_details": {
                      "cached_tokens": 0
                    },
                    "prompt_cache_hit_tokens": 0,
                    "prompt_cache_miss_tokens": 9
                  },
                  "system_fingerprint": "fp_3a5770e1b4"
                }';
    }

    /**
     * @throws InvalidFrequencyPenaltyChatCompletionException
     * @throws InvalidModelChatCompletionException
     * @throws InvalidRoleMessageException|InvalidResponseFormatType
     */
    public function testEndpoint(): void
    {
        $endpoint = $this->client
            ->createChatCompletion()
            ->setModel('deepseek-chat')
            ->setSystemMessage('You are my assistant')
            ->setUserMessage('Hello');


        // Assert endpoint
        $this->assertInstanceOf(CreateChatCompletionDeepseekEndpoint::class, $endpoint);
        $this->assertInstanceOf(
            SystemMessageDto::class,
            $endpoint->getMessages()[DeepseekMessageRoleEnum::MESSAGE_ROLE_SYSTEM->value]
        );
        $this->assertInstanceOf(
            UserMessageDto::class,
            $endpoint->getMessages()[DeepseekMessageRoleEnum::MESSAGE_ROLE_USER->value]
        );

        $response = $endpoint->call();

        $this->assertInstanceOf(ChatCompletionResponseDto::class, $response);
        $this->assertInstanceOf(Collection::class, $response->choices);

        $firstChoice = $response->choices->first();
        $this->assertInstanceOf(ChatChoiceDto::class, $firstChoice);
        $this->assertInstanceOf(MessageDto::class, $firstChoice->message);
        $this->assertEquals(
            DeepseekMessageRoleEnum::MESSAGE_ROLE_ASSISTANT,
            $firstChoice->message->role
        );
    }

    /**
     * @throws InvalidResponseFormatType
     * @throws InvalidFrequencyPenaltyChatCompletionException
     */
    public function testSettingInvalidModel(): void
    {
        $this->expectException(InvalidModelChatCompletionException::class);

        $endpoint = $this->client
            ->createChatCompletion()
            ->setModel('invalid-model');
    }

    /**
     * @throws InvalidResponseFormatType
     * @throws InvalidFrequencyPenaltyChatCompletionException
     * @throws InvalidModelChatCompletionException
     */
    public function testSettingInvalidFrequencyPenalty(): void
    {
        $this->expectException(InvalidFrequencyPenaltyChatCompletionException::class);

        $endpoint = $this->client
            ->createChatCompletion()
            ->setFrequencyPenalty(4);
    }

    /**
     * @throws InvalidResponseFormatType
     * @throws InvalidModelChatCompletionException
     * @throws InvalidPresencePenaltyChatCompletionException
     * @throws InvalidFrequencyPenaltyChatCompletionException
     */
    public function testSettingInvalidPresencePenalty(): void
    {
        $this->expectException(InvalidPresencePenaltyChatCompletionException::class);

        $endpoint = $this->client
            ->createChatCompletion()
            ->setPresencePenalty(4);
    }

    /**
     * @throws InvalidResponseFormatType
     * @throws InvalidRoleMessageException
     * @throws InvalidModelChatCompletionException
     * @throws InvalidFrequencyPenaltyChatCompletionException
     */
    public function testToJson(): void
    {
        $endpoint = $this->client
            ->createChatCompletion()
            ->setModel('deepseek-chat')
            ->setSystemMessage('You are my assistant')
            ->setUserMessage('Hello')
            ->setStreamOptions([
                new SteamOptionDto(true)
            ])
            ->setTools([]);

        $json = $endpoint->toJson();

        $this->assertJson($json);

    }
}
