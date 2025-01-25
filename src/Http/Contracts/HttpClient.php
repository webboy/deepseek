<?php

namespace Webboy\Deepseek\Http\Contracts;

/**
 * Interface HttpClient
 */
interface HttpClient
{
    /**
     * Make a request to the Deepseek API.
     * @param string $method
     * @param string $endpoint
     * @param array $headers
     * @param array $data
     * @return array
     */
    public function request(
        string $method,
        string $endpoint,
        array $headers = [],
        array $data = []
    ): array;
}