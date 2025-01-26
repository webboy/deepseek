<?php

namespace Endpoints;

use Illuminate\Support\Collection;
use Tests\Endpoints\EndpointTestBase;
use Webboy\Deepseek\Dto\Responses\AiModel\AiModelListResponseDto;
use Webboy\Deepseek\Dto\Responses\UserBalance\BalanceInfoResponseDto;
use Webboy\Deepseek\Dto\Responses\UserBalance\UserBalanceResponseDto;
use Webboy\Deepseek\Endpoints\GetBalance\GetBalanceDeepseekEndpoint;
use Webboy\Deepseek\Endpoints\ListModels\ListModelsDeepseekEndpoint;

class ListModelsEndpointTest extends EndpointTestBase
{
    public function getSuccessJson(): string
    {
        return '{
                  "object": "list",
                  "data": [
                    {
                      "id": "deepseek-chat",
                      "object": "model",
                      "owned_by": "deepseek"
                    },
                    {
                      "id": "deepseek-reasoner",
                      "object": "model",
                      "owned_by": "deepseek"
                    }
                  ]
                }';
    }

    public function testEndpoint(): void
    {
        $endpoint = $this->client
            ->listModels();

        // Assert endpoint
        $this->assertInstanceOf(ListModelsDeepseekEndpoint::class, $endpoint);

        $response = $endpoint->call();

        $this->assertNotNull($response);
        $this->assertInstanceOf(AiModelListResponseDto::class, $response);
        $this->assertInstanceOf(Collection::class, $response->data);
    }
}