<?php

namespace Webboy\Deepseek;

use http\Env;
use Webboy\Deepseek\Endpoints\CreateChatCompletion\CreateChatCompletionDeepseekEndpoint;
use Webboy\Deepseek\Endpoints\GetBalance\GetBalanceDeepseekEndpoint;
use Webboy\Deepseek\Endpoints\ListModels\ListModelsDeepseekEndpoint;
use Webboy\Deepseek\Enums\DeepseekHttpClientEnum;
use Webboy\Deepseek\Exceptions\DeepseekerExceptions\InvalidHttpClientIdDeepseekerException;
use Webboy\Deepseek\Exceptions\DtoExceptions\ChatCompletionExceptions\InvalidFrequencyPenaltyChatCompletionException;
use Webboy\Deepseek\Exceptions\DtoExceptions\ChatCompletionExceptions\InvalidModelChatCompletionException;
use Webboy\Deepseek\Exceptions\DtoExceptions\ResponseFormatExceptions\InvalidResponseFormatType;
use Webboy\Deepseek\Http\Contracts\HttpClient;
use Webboy\Deepseek\Http\GuzzleHttp;

/**
 * Class DeepseekClient
 *
 * This class provides a client for interacting with the Deepseek API.
 * It allows for making requests to various endpoints such as retrieving user balance,
 * listing available AI models, and creating chat completions.
 */
class DeepseekClient
{
    /**
     * @var HttpClient The HTTP client used to make requests to the Deepseek API.
     */
    public HttpClient $httpClient;

    /**
     * DeepseekClient constructor.
     *
     * @param string $apiKey The API key for authenticating requests to the Deepseek API.
     * @param HttpClient|null $httpClient The HTTP client to use. If not provided, a default GuzzleHttp client will be used.
     */
    public function __construct(protected string $apiKey, HttpClient $httpClient = null)
    {
        $this->setCustomHttpClient($httpClient ?? new GuzzleHttp($this->apiKey));
    }

    /**
     * Sets a custom HTTP client for making requests.
     *
     * @param HttpClient|null $httpClient The HTTP client to use.
     * @return $this Returns the current instance for method chaining.
     */
    public function setCustomHttpClient(?HttpClient $httpClient): self
    {
        if ($httpClient) {
            $this->httpClient = $httpClient;
        }

        return $this;
    }

    /**
     * Switches the HTTP client based on the provided client ID.
     *
     * @param string $clientId The ID of the HTTP client to use.
     * @return $this Returns the current instance for method chaining.
     * @throws InvalidHttpClientIdDeepseekerException If the provided client ID is invalid.
     */
    public function useHttpClient(string $clientId): self
    {
        $httpClientEnum = DeepseekHttpClientEnum::tryFrom($clientId);

        if ($httpClientEnum === null) {
            throw new InvalidHttpClientIdDeepseekerException($clientId);
        }

        $this->setCustomHttpClient($httpClientEnum->getHttpClient($this->apiKey));

        return $this;
    }


    /**
     * Retrieves the user's balance from the Deepseek API.
     * @return GetBalanceDeepseekEndpoint
     */
    public function getBalance(): GetBalanceDeepseekEndpoint
    {
        return new GetBalanceDeepseekEndpoint($this);
    }

    /**
     * Lists the available AI models from the Deepseek API.
     * @return ListModelsDeepseekEndpoint
     */
    public function listModels(): ListModelsDeepseekEndpoint
    {
        return new ListModelsDeepseekEndpoint($this);
    }

    /**
     * @throws InvalidModelChatCompletionException
     * @throws InvalidFrequencyPenaltyChatCompletionException
     * @throws InvalidResponseFormatType
     */
    public function createChatCompletion(): CreateChatCompletionDeepseekEndpoint
    {
        return new CreateChatCompletionDeepseekEndpoint($this);
    }
}
