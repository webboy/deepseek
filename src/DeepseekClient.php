<?php

namespace Webboy\Deepseek;

use Webboy\Deepseek\Dto\Responses\AiModel\AiModel;
use Webboy\Deepseek\Dto\Responses\UserBalance\BalanceInfo;
use Webboy\Deepseek\Dto\Responses\UserBalance\UserBalanceDto;
use Webboy\Deepseek\Exceptions\HttpClientException;
use Webboy\Deepseek\Http\Contracts\HttpClient;
use Webboy\Deepseek\Http\GuzzleHttp;
use Webboy\Deepseek\Models\DeepseekChat;

class DeepseekClient
{
    private DeepseekChat $chatModel;

    protected HttpClient $httpClient;

    public function __construct(string $apiKey, HttpClient $httpClient = null)
    {
        $this->httpClient = $httpClient ?? new GuzzleHttp($apiKey);

        $this->chatModel = new DeepseekChat();
    }

    /**
     * Get user balance
     * @return UserBalanceDto
     * @throws HttpClientException
     */
    public function getBalance(): UserBalanceDto
    {
        $response = $this->httpClient->request('GET', 'user/balance');

        return new UserBalanceDto(
            is_available: $response['is_available'],
            balance_infos: array_map(fn($balanceInfo) => new BalanceInfo(
                currency: $balanceInfo['currency'],
                total_balance: $balanceInfo['total_balance'],
                granted_balance: $balanceInfo['granted_balance'],
                topped_up_balance: $balanceInfo['topped_up_balance']
            ), $response['balance_infos'])
        );
    }

    /**
     * Get available AI models
     *
     * @return AiModel[]
     * @throws HttpClientException
     */
    public function getModels(): array
    {
        $response = $this->httpClient->request('GET', 'models');

        return array_map(fn($model) => new AiModel(
            id: $model['id'],
            object: $model['object'],
            owned_by: $model['owned_by']
        ),
        $response['data']);
    }
}