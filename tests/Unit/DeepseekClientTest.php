<?php
namespace Unit;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Webboy\Deepseek\DeepseekClient;
use Webboy\Deepseek\Exceptions\DeepseekerExceptions\InvalidHttpClientIdDeepseekerException;
use Webboy\Deepseek\Http\Contracts\HttpClient;

class DeepseekClientTest extends TestCase
{
    /**
     * Test constructing the client with a mocked HTTP client.
     * @throws Exception
     */
    public function testConstructorWithMockedHttpClient()
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
    public function testSetCustomHttpClient()
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
    public function testUseHttpClientWithInvalidId()
    {
        $this->expectException(InvalidHttpClientIdDeepseekerException::class);

        $client = new DeepseekClient('fake-api-key');
        $client->useHttpClient('invalid-client-id');
    }

}