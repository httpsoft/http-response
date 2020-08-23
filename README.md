# HTTP Response

[![License](https://poser.pugx.org/httpsoft/http-response/license)](https://packagist.org/packages/httpsoft/http-response)
[![Latest Stable Version](https://poser.pugx.org/httpsoft/http-response/v)](https://packagist.org/packages/httpsoft/http-response)
[![Total Downloads](https://poser.pugx.org/httpsoft/http-response/downloads)](https://packagist.org/packages/httpsoft/http-response)
[![GitHub Build Status](https://github.com/httpsoft/http-response/workflows/build/badge.svg)](https://github.com/httpsoft/http-response/actions)
[![Scrutinizer Code Coverage](https://scrutinizer-ci.com/g/httpsoft/http-response/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/httpsoft/http-response/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/httpsoft/http-response/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/httpsoft/http-response/?branch=master)

This package contains a collection of classes that implements [Psr\Http\Message\ResponseInterface](https://github.com/php-fig/http-message/blob/master/src/ResponseInterface.php) from [PSR-7 HTTP Message](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-7-http-message.md) in accordance with the [RFC 7230](https://tools.ietf.org/html/rfc7230) and [RFC 7231](https://tools.ietf.org/html/rfc7231) specifications. 

## Documentation

* [In English language](https://httpsoft.org/docs/response).
* [In Russian language](https://httpsoft.org/ru/docs/response).

## Installation

This package requires PHP version 7.4 or later.

```
composer require httpsoft/http-response
```

## Usage

```php
// Create `Psr\Http\Message\ResponseInterface` instance from HTML: 
$response = new HttpSoft\Response\HtmlResponse('<p>HTML</p>');
$response->getHeaderLine('content-type'); // 'text/html; charset=UTF-8'

// Create `Psr\Http\Message\ResponseInterface` instance from data to convert to JSON: 
$response = new HttpSoft\Response\JsonResponse(['key' => 'value']);
$response->getHeaderLine('content-type'); // 'application/json; charset=UTF-8'

// Create `Psr\Http\Message\ResponseInterface` instance from Text: 
$response = new HttpSoft\Response\TextResponse('Text');
$response->getHeaderLine('content-type'); // 'text/plain; charset=UTF-8'

// Create `Psr\Http\Message\ResponseInterface` instance from XML: 
$response = new HttpSoft\Response\XmlResponse('<xmltag>XML</xmltag>');
$response->getHeaderLine('content-type'); // 'application/xml; charset=UTF-8'

// Create `Psr\Http\Message\ResponseInterface` instance for redirect: 
$response = new HttpSoft\Response\RedirectResponse('https/example.com');
$response->getHeaderLine('location'); // 'https/example.com'

// Create `Psr\Http\Message\ResponseInterface` instance for empty response: 
$response = new HttpSoft\Response\EmptyResponse();
$response->getStatusCode(); // 204
$response->getReasonPhrase(); // 'No Content'
```
