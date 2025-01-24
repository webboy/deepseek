<?php

namespace Webboy\Deepseek\Models;

use Webboy\Deepseek\Abstractions\BaseModel;

class DeepseekReasoner extends BaseModel
{
    public function generate(array $prompt): array
    {
        return $this->httpClient->request('POST', 'reasoner/generate', [
            'prompt' => $prompt,
        ]);
    }
}