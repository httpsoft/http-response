<?php

declare(strict_types=1);

namespace HttpSoft\Response;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

final class ResponseFactory implements ResponseFactoryInterface
{
    /**
     * @param int $statusCode
     * @param array $headers
     * @param StreamInterface|string|resource $body
     * @param string $protocol
     * @param string $reasonPhrase
     * @return ResponseInterface
     */
    public static function create(
        int $statusCode = Response::STATUS_OK,
        array $headers = [],
        $body = 'php://temp',
        string $protocol = '1.1',
        string $reasonPhrase = ''
    ): ResponseInterface {
        return new Response($statusCode, $headers, $body, $protocol, $reasonPhrase);
    }

    /**
     * {@inheritDoc}
     */
    public function createResponse(int $code = Response::STATUS_OK, string $reasonPhrase = ''): ResponseInterface
    {
        return new Response($code, [], 'php://temp', '1.1', $reasonPhrase);
    }
}
