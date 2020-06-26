<?php

declare(strict_types=1);

namespace HttpSoft\Response;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

final class Response implements ResponseInterface, ResponseStatusCodeInterface
{
    use ResponseTrait;

    /**
     * @param int $statusCode
     * @param string $reasonPhrase
     * @param StreamInterface|string|resource $body
     * @param array $headers
     * @param string $protocol
     */
    public function __construct(
        int $statusCode = self::STATUS_OK,
        string $reasonPhrase = '',
        $body = 'php://temp',
        array $headers = [],
        string $protocol = '1.1'
    ) {
        $this->init($statusCode, $reasonPhrase, $body, $headers, $protocol);
    }
}
