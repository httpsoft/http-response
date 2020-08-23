<?php

declare(strict_types=1);

namespace HttpSoft\Response;

use Psr\Http\Message\ResponseInterface;

final class RedirectResponse implements ResponseInterface, ResponseStatusCodeInterface
{
    use ResponseExtensionTrait;

    /**
     * @param string $uri
     * @param int $code
     * @param array $headers
     * @param string $protocol
     * @param string $reasonPhrase
     */
    public function __construct(
        string $uri,
        int $code = self::STATUS_FOUND,
        array $headers = [],
        string $protocol = '1.1',
        string $reasonPhrase = ''
    ) {
        $headers['Location'] = $uri;
        $this->init($code, $reasonPhrase, $headers, 'php://temp', $protocol);
    }
}
