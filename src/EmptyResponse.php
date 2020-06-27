<?php

declare(strict_types=1);

namespace HttpSoft\Response;

use HttpSoft\Stream\StreamFactory;
use Psr\Http\Message\ResponseInterface;

final class EmptyResponse implements ResponseInterface, ResponseStatusCodeInterface
{
    use ResponseTrait;

    /**
     * @param int $code
     * @param array $headers
     * @param string $protocol
     * @param string $reasonPhrase
     */
    public function __construct(
        int $code = self::STATUS_NO_CONTENT,
        array $headers = [],
        string $protocol = '1.1',
        string $reasonPhrase = ''
    ) {
        $this->init($code, $reasonPhrase, StreamFactory::create('php://temp', 'r'), $headers, $protocol);
    }
}
