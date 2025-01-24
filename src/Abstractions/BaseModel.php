<?php

namespace Webboy\Deepseek\Abstractions;

use Webboy\Deepseek\Contracts\HttpClient;

abstract class BaseModel
{
    protected HttpClient $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }
}