# Deepseek PHP Client

A PHP client for interacting with the Deepseek AI API, providing easy-to-use methods to communicate with Deepseek's services.

## Installation

Install the package via Composer:

```bash
composer require webboy/deepseek
```

## Requirements

[![Latest Stable Version](https://img.shields.io/packagist/v/webboy/deepseek.svg)](https://packagist.org/packages/webboy/deepseek)
[![Total Downloads](https://img.shields.io/packagist/dt/webboy/deepseek.svg)](https://packagist.org/packages/webboy/deepseek)

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