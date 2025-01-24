<?php

namespace Webboy\Deepseek\Contracts;

/**
 * Interface HttpClient
 */
interface HttpClient
{
    /**
     * Make a request to the Deepseek API.
     * @param string $method
     * @param string $endpoint
     * @param array $data
     * @return array
     */
    public function request(
        string $method,
        string $endpoint,
        array $data = []
    ): array;
}