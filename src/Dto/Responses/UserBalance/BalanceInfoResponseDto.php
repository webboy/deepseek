<?php

namespace Webboy\Deepseek\Dto\Responses\UserBalance;

use Webboy\Deepseek\Dto\BaseDto;

class BalanceInfoResponseDto extends BaseDto
{
    public function __construct(
        protected string $currency,
        protected float $total_balance,
        protected float $granted_balance,
        protected float $topped_up_balance
    ) {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            currency: $data['currency'],
            total_balance: $data['total_balance'],
            granted_balance: $data['granted_balance'],
            topped_up_balance: $data['topped_up_balance']
        );
    }
}
