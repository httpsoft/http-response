<?php

declare(strict_types=1);

namespace HttpSoft\Response;

use HttpSoft\Stream\StreamFactory;
use Psr\Http\Message\ResponseInterface;

final class XmlResponse implements ResponseInterface, ResponseStatusCodeInterface
{
    use ResponseTrait;

    /**
     * @param string $xml
     * @param int $code
     * @param array $headers
     * @param string $protocol
     * @param string $reasonPhrase
     */
    public function __construct(
        string $xml,
        int $code = self::STATUS_OK,
        array $headers = [],
        string $protocol = '1.1',
        string $reasonPhrase = ''
    ) {
        $this->init($code, $reasonPhrase, $headers, StreamFactory::createFromContent($xml), $protocol);
        $this->setContentTypeHeaderIfNotExists('application/xml; charset=UTF-8');
    }
}
