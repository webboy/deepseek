<?php

namespace Webboy\Deepseek;

use Illuminate\Support\Collection;
use Webboy\Deepseek\Dto\Requests\CreateChatCompletion\CreateChatCompletionRequestDto;
use Webboy\Deepseek\Dto\Responses\AiModel\AiModelListResponseDto;
use Webboy\Deepseek\Dto\Responses\AiModel\AiModelResponseDto;
use Webboy\Deepseek\Dto\Responses\ChatCompletion\ChatCompletionResponseDto;
use Webboy\Deepseek\Dto\Responses\UserBalance\BalanceInfoResponseDto;
use Webboy\Deepseek\Dto\Responses\UserBalance\UserBalanceResponseDto;
use Webboy\Deepseek\Exceptions\HttpClientException;
use Webboy\Deepseek\Http\Contracts\HttpClient;
use Webboy\Deepseek\Http\GuzzleHttp;

class DeepseekClient
{
    protected HttpClient $httpClient;

    public function __construct(string $apiKey, HttpClient $httpClient = null)
    {
        $this->httpClient = $httpClient ?? new GuzzleHttp($apiKey);
    }

    /**
     * Get user balance
     * @return UserBalanceResponseDto
     * @throws HttpClientException
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
     * @throws HttpClientException
     */
    public function listModels(): AiModelListResponseDto
    {
        $response = $this->httpClient->request('GET', 'models');

        return AiModelListResponseDto::fromArray($response);
    }

    /**
     * @throws HttpClientException
     */
    public function createChatCompletion(CreateChatCompletionRequestDto $request): ChatCompletionResponseDto
    {
        $response = $this->httpClient->request('POST', 'chat/completions', [], $request->toArray());

        return ChatCompletionResponseDto::fromArray($response);
    }
}