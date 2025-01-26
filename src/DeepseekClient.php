<?php

namespace Webboy\Deepseek;

use Webboy\Deepseek\Dto\Requests\CreateChatCompletion\CreateChatCompletionRequestDto;
use Webboy\Deepseek\Dto\Responses\AiModel\AiModelListResponseDto;
use Webboy\Deepseek\Dto\Responses\ChatCompletion\ChatCompletionResponseDto;
use Webboy\Deepseek\Dto\Responses\UserBalance\UserBalanceResponseDto;
use Webboy\Deepseek\Enums\DeepseekHttpClientEnum;
use Webboy\Deepseek\Exceptions\DeepseekerExceptions\InvalidHttpClientIdDeepseekerException;
use Webboy\Deepseek\Http\Contracts\HttpClient;
use Webboy\Deepseek\Http\GuzzleHttp;

class DeepseekClient
{
    protected HttpClient $httpClient;

    public function __construct(protected string $apiKey, HttpClient $httpClient = null)
    {
        $this->setCustomHttpClient($httpClient ?? new GuzzleHttp($this->apiKey));
    }

    /**
     * @param HttpClient|null $httpClient
     * @return $this
     */
    public function setCustomHttpClient(?HttpClient $httpClient): self
    {
        if ($httpClient) {
            $this->httpClient = $httpClient;
        }

        return $this;
    }

    /**
     * @throws InvalidHttpClientIdDeepseekerException
     */
    public function useHttpClient(string $clientId): self
    {
        $httpClientEnum = DeepseekHttpClientEnum::tryFrom($clientId);

        if ($httpClientEnum === null) {
            throw new InvalidHttpClientIdDeepseekerException($clientId);
        }

        $this->setCustomHttpClient($httpClientEnum->getHttpClient($this->apiKey));

        return $this;
    }

    /**
     * Get user balance
     * @return UserBalanceResponseDto
     */
    public function getBalance(): UserBalanceResponseDto
    {
        $response = $this->httpClient->request('GET', 'user/balance');

        return UserBalanceResponseDto::fromArray($response);
    }

    /**
     * Get available AI models
     *
     * @return AiModelListResponseDto
     */
    public function listModels(): AiModelListResponseDto
    {
        $response = $this->httpClient->request('GET', 'models');

        return AiModelListResponseDto::fromArray($response);
    }

    public function createChatCompletion(CreateChatCompletionRequestDto $request): ChatCompletionResponseDto
    {
        $response = $this->httpClient->request('POST', 'chat/completions', [], $request->toArray());

        return ChatCompletionResponseDto::fromArray($response);
    }
}
