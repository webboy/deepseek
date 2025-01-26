<?php

namespace Webboy\Deepseek\Dto\Responses\ChatCompletion;

use Webboy\Deepseek\Dto\Responses\ResponseDto;

class UsageDto extends ResponseDto
{
    public function __construct(
        protected int $completion_tokens,
        protected int $prompt_tokens,
        protected int $prompt_cache_hit_tokens,
        protected int $prompt_cache_miss_tokens,
        protected int $total_tokens,
        protected PromptTokenDetailsDto $prompt_tokens_details
    ){}

    public static function fromArray(array $data): static
    {
        return new self(
            completion_tokens: $data['completion_tokens'],
            prompt_tokens: $data['prompt_tokens'],
            prompt_cache_hit_tokens: $data['prompt_cache_hit_tokens'],
            prompt_cache_miss_tokens: $data['prompt_cache_miss_tokens'],
            total_tokens: $data['total_tokens'],
            prompt_tokens_details: PromptTokenDetailsDto::fromArray($data['prompt_tokens_details'] ?? []),
        );
    }
}