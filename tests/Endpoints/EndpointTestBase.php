<?php

namespace Tests\Endpoints;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Webboy\Deepseek\DeepseekClient;
use Webboy\Deepseek\Http\Contracts\HttpClient;

abstract class EndpointTestBase extends TestCase
{
    protected DeepseekClient $client;

    abstract public function getSuccessJson(): string;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $httpClientMock = $this->createMock(HttpClient::class);

        $httpClientMock->method('request')
            ->willReturn(json_decode($this->getSuccessJson(), true));

        $this->client = new DeepseekClient('fake-api-key', $httpClientMock);
    }

    abstract public function testEndpoint(): void;

}