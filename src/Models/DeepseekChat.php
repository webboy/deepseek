<?php

namespace Webboy\Deepseek\Models;

use Webboy\Deepseek\Http\Contracts\HttpClient;

class DeepseekChat extends BaseModel
{
    public function __construct()
    {
        parent::__construct('deepseek-chat');
    }
}