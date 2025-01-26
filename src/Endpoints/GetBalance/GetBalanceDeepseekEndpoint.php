<?php

namespace Webboy\Deepseek\Endpoints\GetBalance;

use Webboy\Deepseek\Dto\Responses\UserBalance\UserBalanceResponseDto;
use Webboy\Deepseek\Endpoints\DeepseekEndpoint;

class GetBalanceDeepseekEndpoint extends DeepseekEndpoint
{
    public function call(): UserBalanceResponseDto
    {
        $response = $this
            ->getHttpClient()
            ->request('GET', 'user/balance');

        return UserBalanceResponseDto::fromArray($response);
    }
}
