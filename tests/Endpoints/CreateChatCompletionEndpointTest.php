<?php

namespace Endpoints;

use Illuminate\Support\Collection;
use Tests\Endpoints\EndpointTestBase;
use Webboy\Deepseek\Dto\Requests\CreateChatCompletion\Message\SystemMessageDto;
use Webboy\Deepseek\Dto\Requests\CreateChatCompletion\Message\UserMessageDto;
use Webboy\Deepseek\Dto\Responses\AiModel\AiModelListResponseDto;
use Webboy\Deepseek\Dto\Responses\ChatCompletion\ChatCompletionResponseDto;
use Webboy\Deepseek\Endpoints\CreateChatCompletion\CreateChatCompletionDeepseekEndpoint;
use Webboy\Deepseek\Endpoints\ListModels\ListModelsDeepseekEndpoint;
use Webboy\Deepseek\Enums\DeepseekMessageRoleEnum;
use Webboy\Deepseek\Exceptions\DtoExceptions\ChatCompletionExceptions\InvalidFrequencyPenaltyChatCompletionException;
use Webboy\Deepseek\Exceptions\DtoExceptions\ChatCompletionExceptions\InvalidModelChatCompletionException;
use Webboy\Deepseek\Exceptions\DtoExceptions\MessageExceptions\InvalidRoleMessageException;

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
     * @throws InvalidRoleMessageException
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
        $this->assertInstanceOf(SystemMessageDto::class, $endpoint->getMessages()[DeepseekMessageRoleEnum::MESSAGE_ROLE_SYSTEM->value]);
        $this->assertInstanceOf(UserMessageDto::class, $endpoint->getMessages()[DeepseekMessageRoleEnum::MESSAGE_ROLE_USER->value]);

        $response = $endpoint->call();

        $this->assertNotNull($response);
        $this->assertInstanceOf(ChatCompletionResponseDto::class, $response);
    }
}