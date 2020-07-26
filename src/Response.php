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
     * @param array $headers
     * @param StreamInterface|string|resource $body
     * @param string $protocol
     * @param string $reasonPhrase
     */
    public function __construct(
        int $statusCode = self::STATUS_OK,
        array $headers = [],
        $body = 'php://temp',
        string $protocol = '1.1',
        string $reasonPhrase = ''
    ) {
        $this->init($statusCode, $reasonPhrase, $headers, $body, $protocol);
    }
}
