<?php

namespace Webboy\Deepseek\Dto\Responses\UserBalance;

use Illuminate\Support\Collection;
use Webboy\Deepseek\Dto\Responses\ResponseDto;

/**
 * Class UserBalanceResponseDto
 * @package Webboy\Deepseek\Dto\Responses\UserBalance
 */
class UserBalanceResponseDto extends ResponseDto
{
    /**
     * UserBalanceResponseDto constructor.
     * @param bool $is_available
     * @param Collection<int,BalanceInfoResponseDto> $balance_infos
     */
    public function __construct(
        public bool $is_available,
        public Collection $balance_infos
    ) {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            is_available: $data['is_available'],
            balance_infos: collect($data['balance_infos'])
                ->map(fn ($balanceInfo) => BalanceInfoResponseDto::fromArray($balanceInfo))
        );
    }
}
