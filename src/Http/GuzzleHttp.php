<?php

namespace Webboy\Deepseek\Http;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
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
     * @return array<mixed> The response from the API as an associative array.
     * @throws HttpClientException If the request fails or an error occurs during the request.
     */
    public function request(string $method, string $endpoint, array $headers = [], array $data = []): array
    {
        try {
            $requestBody = json_encode($data);
            if ($requestBody === false) {
                throw new HttpClientException('Failed to encode data to JSON: ' . json_last_error_msg());
            }

            $request = new Request($method, $endpoint, $headers, $requestBody);

            /** @var ResponseInterface $response */
            $response = $this->client->sendAsync($request)->wait();

            $responseBody = (string) $response->getBody();

            $decodedResponse = json_decode($responseBody, true);

            if (!is_array($decodedResponse)) {
                throw new HttpClientException('Invalid response format: Expected JSON object.');
            }

            return $decodedResponse;

        } catch (Exception $e) {
            // Handle specific Guzzle exceptions here
            throw new HttpClientException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
