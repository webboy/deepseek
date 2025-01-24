<?php

namespace Webboy\Deepseek\Http;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Webboy\Deepseek\Contracts\HttpClient;
use Webboy\Deepseek\Exceptions\HttpClientException;

class GuzzleHttp implements HttpClient
{
    private Client $client;

    public function __construct(string $apiKey, string $baseUri = null)
    {
        $this->client = new Client([
            'base_uri' => $baseUri ?? 'https://api.deepseek.com',
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
     * @param array $data
     * @return array
     * @throws HttpClientException
     */
    public function request(string $method, string $endpoint, array $data = []): array
    {
        try {
            $response = $this->client->request($method, $endpoint, [
                'json' => $data
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            // Handle specific Guzzle exceptions here
            throw new HttpClientException($e->getMessage(), $e->getCode(), $e);
        }
    }
}