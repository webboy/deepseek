<?php

namespace Webboy\Deepseek\Http;

use Webboy\Deepseek\Exceptions\HttpClientException;
use Webboy\Deepseek\Http\Contracts\HttpClient;

/**
 * Class CurlHttp
 *
 * This class implements the `HttpClient` interface using the cURL library.
 * It is responsible for making HTTP requests to the Deepseek API using cURL.
 */
class CurlHttp implements HttpClient
{
    /**
     * @var string The API key for authenticating requests to the Deepseek API.
     */
    private string $apiKey;

    /**
     * @var string The base URI for the Deepseek API.
     */
    private string $baseUri;

    /**
     * CurlHttp constructor.
     *
     * Initializes the cURL HTTP client with the provided API key and base URI.
     *
     * @param string $apiKey The API key for authenticating requests to the Deepseek API.
     * @param string|null $baseUri The base URI for the Deepseek API. Defaults to 'https://api.deepseek.com/' if not provided.
     */
    public function __construct(string $apiKey, string $baseUri = null)
    {
        $this->apiKey = $apiKey;
        $this->baseUri = $baseUri ?? 'https://api.deepseek.com/';
    }

    /**
     * Makes an HTTP request to the Deepseek API using cURL.
     *
     * @param string $method The HTTP method (e.g., GET, POST).
     * @param string $endpoint The API endpoint to request.
     * @param array $headers Additional headers to include in the request.
     * @param array $data The request payload data.
     * @return array The response from the API as an associative array.
     * @throws HttpClientException If the request fails or an error occurs during the request.
     */
    public function request(string $method, string $endpoint, array $headers = [], array $data = []): array
    {
        $curl = curl_init();

        // Prepare URL
        $url = $this->baseUri . $endpoint;

        // Set method-specific options
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
            CURLOPT_HTTPHEADER => $this->prepareHeaders($headers),
            CURLOPT_SSL_VERIFYHOST => 0, // Disable SSL host verification
            CURLOPT_SSL_VERIFYPEER => false, // Disable SSL certificate verification
        ];

        // Add POST/PUT payload, if applicable
        if (in_array(strtoupper($method), ['POST', 'PUT', 'PATCH'], true) && !empty($data)) {
            $options[CURLOPT_POSTFIELDS] = json_encode($data);
        }

        curl_setopt_array($curl, $options);

        // Execute the request
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Handle cURL errors
        if (curl_errno($curl)) {
            throw new HttpClientException('CURL Error: ' . curl_error($curl));
        }

        curl_close($curl);

        // Handle HTTP errors
        if ($httpCode < 200 || $httpCode >= 300) {
            throw new HttpClientException("HTTP Error: Received response code $httpCode with body: $response");
        }

        // Return decoded response
        return json_decode($response, true);
    }

    /**
     * Prepares headers for the cURL request.
     *
     * This method merges default headers (e.g., Authorization and Content-Type) with any additional headers provided.
     *
     * @param array $headers Additional headers to include in the request.
     * @return array The final array of headers to be used in the cURL request.
     */
    private function prepareHeaders(array $headers): array
    {
        $defaultHeaders = [
            'Authorization: Bearer ' . $this->apiKey,
            'Content-Type: application/json',
        ];

        foreach ($headers as $key => $value) {
            $defaultHeaders[] = "$key: $value";
        }

        return $defaultHeaders;
    }
}
