<?php

namespace Webboy\Deepseek\Http;

use Webboy\Deepseek\Exceptions\HttpClientException;
use Webboy\Deepseek\Http\Contracts\HttpClient;

class CurlHttp implements HttpClient
{
    private string $apiKey;
    private string $baseUri;

    public function __construct(string $apiKey, string $baseUri = null)
    {
        $this->apiKey = $apiKey;
        $this->baseUri = $baseUri ?? 'https://api.deepseek.com/';
    }

    /**
     * Make a request to the Deepseek API using cURL.
     *
     * @param string $method
     * @param string $endpoint
     * @param array $headers
     * @param array $data
     * @return array
     * @throws HttpClientException
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
     * Prepare headers for the cURL request.
     *
     * @param array $headers
     * @return array
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
