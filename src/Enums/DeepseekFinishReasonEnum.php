<?php

namespace Webboy\Deepseek\Enums;

/**
 * Possible values: [stop, length, content_filter, tool_calls, insufficient_system_resource]
 *
 * The reason the model stopped generating tokens. This will be stopped if the model hit a natural stop point or a
 * provided stop sequence, length if the maximum number of tokens specified in the request was reached,
 * content_filter if content was omitted due to a flag from our content filters, tool_calls if the model called a tool,
 * or insufficient_system_resource if the request is interrupted due to insufficient resource of the inference system.
 */
enum DeepseekFinishReasonEnum: string
{
    case STOP = 'stop';

    case LENGTH = 'length';

    case CONTENT_FILTER = 'content_filter';

    case TOOL_CALLS = 'tool_calls';

    case INSUFFICIENT_SYSTEM_RESOURCE = 'insufficient_system_resource';

}
