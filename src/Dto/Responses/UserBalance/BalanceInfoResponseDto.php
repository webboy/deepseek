<?php

namespace Webboy\Deepseek\Dto\Responses\UserBalance;

use Webboy\Deepseek\Dto\BaseDto;

final class BalanceInfoResponseDto extends BaseDto
{
    public function __construct(
        public string $currency,
        public float $total_balance,
        public float $granted_balance,
        public float $topped_up_balance
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
