<?php

namespace Webboy\Deepseek\Endpoints;

use Webboy\Deepseek\DeepseekClient;
use Webboy\Deepseek\Dto\Responses\ResponseDto;
use Webboy\Deepseek\Exceptions\DeepseekEndpointException;
use Webboy\Deepseek\Http\Contracts\HttpClient;

abstract class DeepseekEndpoint
{
    public function __construct(
        protected DeepseekClient $deep_seek_client
    ){}

    protected function getHttpClient(): HttpClient
    {
        return $this->deep_seek_client->httpClient;
    }

    abstract public function call(): ResponseDto;
}