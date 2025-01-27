<?php

namespace Tests\Unit;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Webboy\Deepseek\DeepseekClient;
use Webboy\Deepseek\Enums\DeepseekHttpClientEnum;
use Webboy\Deepseek\Exceptions\DeepseekerExceptions\InvalidHttpClientIdDeepseekerException;
use Webboy\Deepseek\Http\Contracts\HttpClient;
use Webboy\Deepseek\Http\CurlHttp;
use Webboy\Deepseek\Http\GuzzleHttp;

class DeepseekClientTest extends TestCase
{
    /**
     * Test constructing the client with a mocked HTTP client.
     * @throws Exception
     */
    public function testConstructorWithMockedHttpClient(): void
    {
        $httpClientMock = $this->createMock(HttpClient::class);
        $client = new DeepseekClient('fake-api-key', $httpClientMock);

        $this->assertInstanceOf(HttpClient::class, $client->httpClient);
        $this->assertSame($httpClientMock, $client->httpClient);
    }

    /**
     * Test using a custom HTTP client.
     * @throws Exception
     */
    public function testSetCustomHttpClient(): void
    {
        $httpClientMock = $this->createMock(HttpClient::class);

        $client = new DeepseekClient('fake-api-key');
        $client->setCustomHttpClient($httpClientMock);

        $this->assertInstanceOf(HttpClient::class, $client->httpClient);
        $this->assertSame($httpClientMock, $client->httpClient);
    }

    /**
     * Test using an invalid HTTP client with exception.
     */
    public function testUseHttpClientWithInvalidId(): void
    {
        $this->expectException(InvalidHttpClientIdDeepseekerException::class);

        $client = new DeepseekClient('fake-api-key');
        $client->useHttpClient('invalid-client-id');
    }

    /**
     * @throws InvalidHttpClientIdDeepseekerException
     */
    public function testUseHttpClientWithGuzzle(): void
    {
        $client = new DeepseekClient('fake-api-key');
        $client->useHttpClient(DeepseekHttpClientEnum::GUZZLE->value);

        $this->assertInstanceOf(GuzzleHttp::class, $client->httpClient);
    }

    /**
     * @throws InvalidHttpClientIdDeepseekerException
     */
    public function testUseHttpClientWithCurl(): void
    {
        $client = new DeepseekClient('fake-api-key');
        $client->useHttpClient(DeepseekHttpClientEnum::CURL->value);

        $this->assertInstanceOf(CurlHttp::class, $client->httpClient);
    }

}
