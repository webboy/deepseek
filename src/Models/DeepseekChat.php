<?php

namespace Webboy\Deepseek\Models;

use Webboy\Deepseek\Abstractions\BaseModel;

class DeepseekChat extends BaseModel
{
    public function sendMessage(array $messages): array
    {
        return $this->httpClient->request('POST', 'chat/messages', [
            'messages' => $messages,
        ]);
    }
}