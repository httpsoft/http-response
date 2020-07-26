<?php

declare(strict_types=1);

namespace HttpSoft\Response;

use HttpSoft\Stream\StreamFactory;
use Psr\Http\Message\ResponseInterface;

final class TextResponse implements ResponseInterface, ResponseStatusCodeInterface
{
    use ResponseTrait;

    /**
     * @param string $text
     * @param int $code
     * @param array $headers
     * @param string $protocol
     * @param string $reasonPhrase
     */
    public function __construct(
        string $text,
        int $code = self::STATUS_OK,
        array $headers = [],
        string $protocol = '1.1',
        string $reasonPhrase = ''
    ) {
        $this->init($code, $reasonPhrase, $headers, StreamFactory::createFromContent($text), $protocol);
        $this->setContentTypeHeaderIfNotExists('text/plain; charset=UTF-8');
    }
}
