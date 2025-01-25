<?php

namespace Webboy\Deepseek\Dto\Responses\UserBalance;

use Webboy\Deepseek\Dto\BaseDto;

class BalanceInfo extends BaseDto
{
    public function __construct(
        protected string $currency,
        protected float $total_balance,
        protected float $granted_balance,
        protected float $topped_up_balance
    ) {}
}