<?php

namespace Webboy\Deepseek\Endpoints\ListModels;

use Webboy\Deepseek\Dto\Responses\AiModel\AiModelListResponseDto;
use Webboy\Deepseek\Endpoints\DeepseekEndpoint;
use Webboy\Deepseek\Exceptions\DeepseekEndpointException;

class ListModelsDeepseekEndpoint extends DeepseekEndpoint
{
    public function call(): AiModelListResponseDto
    {
        $response = $this
            ->getHttpClient()
            ->request('GET', 'models');

        return AiModelListResponseDto::fromArray($response);
    }
}