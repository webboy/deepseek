<?php

namespace Webboy\Deepseek\Models;

use Webboy\Deepseek\Http\Contracts\HttpClient;

abstract class BaseModel
{
    public function __construct(
        protected string $modelId
    ){}
}