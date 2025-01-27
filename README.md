# Deepseek PHP Client

[![Latest Stable Version](https://img.shields.io/packagist/v/webboy/deepseek.svg)](https://packagist.org/packages/webboy/deepseek)
[![Total Downloads](https://img.shields.io/packagist/dt/webboy/deepseek.svg)](https://packagist.org/packages/webboy/deepseek)

A PHP client for interacting with the Deepseek AI API, providing easy-to-use methods to communicate with Deepseek's services.

## Installation

Install the package via Composer:

```bash
composer require webboy/deepseek
```

## Requirements

PHP ^8.1

ext-json extension

ext-curl extension

## Features

- Easy integration with Deepseek AI API

- Utilizes Guzzle for HTTP requests

- Simple and fluent API for request handling

- Laravel-friendly using illuminate/collections

## Usage

### Initialize the client

```php
use Webboy\Deepseek\Deepseek;

$deepseek = new Deepseek('your-api-key');
```

### Get all models

```php
$response = $client
    ->listModels()
    ->call();
```

### Get user balance
    
```php
$response = $client
    ->getBalance()
    ->call();
```

### Start a chat session

```php
$response = $client
        ->createChatCompletion()
        ->setResponseFormat('text')
        ->setSystemMessage('You are a professional LinkedIn influencer.', 'Agent Smith')
        ->setUserMessage('Write down a short announcement for the initial version for the Deepseek API Client composer package.')
        ->call();
```