<?php

namespace Webboy\Deepseek\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Webboy\Deepseek\Exceptions\HttpClientException;
use Webboy\Deepseek\Http\Contracts\HttpClient;

class GuzzleHttp implements HttpClient
{
    private Client $client;

    public function __construct(string $apiKey, string $baseUri = null)
    {
        $this->client = new Client([
            'base_uri' => $baseUri ?? 'https://api.deepseek.com',
            'verify' => false,
            'headers' => [
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * Make a request to the Deepseek API.
     * @param string $method
     * @param string $endpoint
     * @param array $headers
     * @param array $data
     * @return array
     * @throws HttpClientException
     */
    public function request(string $method, string $endpoint, array $headers = [], array $data = []): array
    {
        try {
            $request = new Request($method, $endpoint, $headers, json_encode($data));

            $response = $this->client->sendAsync($request)->wait();

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            // Handle specific Guzzle exceptions here
            throw new HttpClientException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
