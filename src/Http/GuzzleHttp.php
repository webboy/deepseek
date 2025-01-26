<?php

namespace Webboy\Deepseek\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Webboy\Deepseek\Exceptions\HttpClientException;
use Webboy\Deepseek\Http\Contracts\HttpClient;

/**
 * Class GuzzleHttp
 *
 * This class implements the `HttpClient` interface using the Guzzle HTTP client.
 * It is responsible for making HTTP requests to the Deepseek API.
 */
class GuzzleHttp implements HttpClient
{
    /**
     * @var Client The Guzzle HTTP client instance.
     */
    private Client $client;

    /**
     * GuzzleHttp constructor.
     *
     * Initializes the Guzzle HTTP client with the provided API key and base URI.
     *
     * @param string $apiKey The API key for authenticating requests to the Deepseek API.
     * @param string|null $baseUri The base URI for the Deepseek API. Defaults to 'https://api.deepseek.com' if not provided.
     */
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
     * Makes an HTTP request to the Deepseek API.
     *
     * @param string $method The HTTP method (e.g., GET, POST).
     * @param string $endpoint The API endpoint to request.
     * @param array<string, string> $headers Additional headers to include in the request.
     * @param array<string, mixed> $data The request payload data.
     * @return array<string, mixed> The response from the API as an associative array.
     * @throws HttpClientException If the request fails or an error occurs during the request.
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
