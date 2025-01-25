<?php

namespace Webboy\Deepseek\Dto\Responses\UserBalance;

use Webboy\Deepseek\Dto\Responses\ResponseDto;

/**
 * Class UserBalanceDto
 * @package Webboy\Deepseek\Dto\Responses\UserBalance
 */
class UserBalanceDto extends ResponseDto
{
    /**
     * UserBalanceDto constructor.
     * @param bool $is_available
     * @param BalanceInfo[] $balance_infos
     */
    public function __construct(
        protected bool $is_available,
        protected array $balance_infos
    ) {}
}