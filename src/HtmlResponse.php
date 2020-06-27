<?php

declare(strict_types=1);

namespace HttpSoft\Response;

use HttpSoft\Stream\StreamFactory;
use Psr\Http\Message\ResponseInterface;

final class HtmlResponse implements ResponseInterface, ResponseStatusCodeInterface
{
    use ResponseTrait;

    /**
     * @param string $html
     * @param int $code
     * @param array $headers
     * @param string $protocol
     * @param string $reasonPhrase
     */
    public function __construct(
        string $html,
        int $code = self::STATUS_OK,
        array $headers = [],
        string $protocol = '1.1',
        string $reasonPhrase = ''
    ) {
        $this->init($code, $reasonPhrase, StreamFactory::createFromContent($html), $headers, $protocol);
        $this->setContentTypeHeaderIfNotExists('text/html; charset=UTF-8');
    }
}
