<?php

namespace Tests\Endpoints;

use Illuminate\Support\Collection;
use Webboy\Deepseek\Dto\Responses\UserBalance\BalanceInfoResponseDto;
use Webboy\Deepseek\Dto\Responses\UserBalance\UserBalanceResponseDto;
use Webboy\Deepseek\Endpoints\GetBalance\GetBalanceDeepseekEndpoint;

class GetBalanceEndpointTest extends EndpointTestBase
{
    public function getSuccessJson(): string
    {
        return '{
                    "is_available": true,
                    "balance_infos": [
                        {
                          "currency": "USD",
                          "total_balance": "4.99",
                          "granted_balance": "0.00",
                          "topped_up_balance": "4.99"
                        }
                    ]
                }';
    }

    public function testEndpoint(): void
    {
        $endpoint = $this->client
            ->getBalance();

        // Assert endpoint
        $this->assertInstanceOf(GetBalanceDeepseekEndpoint::class, $endpoint);

        $response = $endpoint->call();

        $this->assertNotNull($response);
        $this->assertInstanceOf(UserBalanceResponseDto::class, $response);
        $this->assertInstanceOf(Collection::class, $response->balance_infos);
        $this->assertInstanceOf(BalanceInfoResponseDto::class, $response->balance_infos->first());
        $this->assertNotNull($response->balance_infos->first()->currency);
        $this->assertNotNull($response->balance_infos->first()->total_balance);
        $this->assertNotNull($response->balance_infos->first()->granted_balance);
        $this->assertNotNull($response->balance_infos->first()->topped_up_balance);
    }
}
