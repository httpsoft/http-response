<?php

declare(strict_types=1);

namespace HttpSoft\Response;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ResponseFactory implements ResponseFactoryInterface
{
    /**
     * @param int $statusCode
     * @param string $reasonPhrase
     * @param StreamInterface|string|resource $body
     * @param array $headers
     * @param string $protocol
     * @return ResponseInterface
     */
    public static function create(
        int $statusCode = Response::STATUS_OK,
        string $reasonPhrase = '',
        $body = 'php://temp',
        array $headers = [],
        string $protocol = '1.1'
    ): ResponseInterface {
        return new Response($statusCode, $reasonPhrase, $body, $headers, $protocol);
    }

    /**
     * {@inheritDoc}
     */
    public function createResponse(int $statusCode = Response::STATUS_OK, string $reasonPhrase = ''): ResponseInterface
    {
        return new Response($statusCode, $reasonPhrase);
    }
}
