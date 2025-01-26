<?php

namespace Webboy\Deepseek\Enums;

use Webboy\Deepseek\Http\Contracts\HttpClient;
use Webboy\Deepseek\Http\CurlHttp;
use Webboy\Deepseek\Http\GuzzleHttp;

enum DeepseekHttpClientEnum: string
{
    case GUZZLE = 'guzzle';
    case CURL = 'curl';

    // Instantiate the HttpClient class

    public function getHttpClient(string $apiKey): HttpClient
    {
        return match ($this) {
            self::GUZZLE => new GuzzleHttp($apiKey),
            self::CURL => new CurlHttp($apiKey),
        };
    }
}
