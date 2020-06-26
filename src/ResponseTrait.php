<?php

declare(strict_types=1);

namespace HttpSoft\Response;

use HttpSoft\Stream\MessageTrait;
use HttpSoft\Stream\StreamFactory;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

use function gettype;
use function get_class;
use function is_int;
use function is_float;
use function is_numeric;
use function is_object;
use function is_string;
use function sprintf;

/**
 * Trait implementing the methods defined in `Psr\Http\Message\ResponseInterface`.
 *
 * @see https://github.com/php-fig/http-message/tree/master/src/ResponseInterface.php
 */
trait ResponseTrait
{
    use MessageTrait;

    /**
     * @var int
     */
    private int $statusCode;

    /**
     * @var string
     */
    private string $reasonPhrase;

    /**
     * Gets the response status code.
     *
     * The status code is a 3-digit integer result code of the server's attempt
     * to understand and satisfy the request.
     *
     * @return int Status code.
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Return an instance with the specified status code and, optionally, reason phrase.
     *
     * If no reason phrase is specified, implementations MAY choose to default
     * to the RFC 7231 or IANA recommended reason phrase for the response's
     * status code.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated status and reason phrase.
     *
     * @link http://tools.ietf.org/html/rfc7231#section-6
     * @link http://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml
     * @param int $code The 3-digit integer result code to set.
     * @param string $reasonPhrase The reason phrase to use with the
     *     provided status code; if none is provided, implementations MAY
     *     use the defaults as suggested in the HTTP specification.
     * @return static
     * @throws InvalidArgumentException for invalid status code arguments.
     */
    public function withStatus($code, $reasonPhrase = ''): ResponseInterface
    {
        if (!is_int($code)) {
            if (!is_numeric($code) || is_float($code)) {
                throw new InvalidArgumentException(sprintf(
                    'Response status code is not valid. Must be a integer, received `%s`.',
                    (is_object($code) ? get_class($code) : gettype($code))
                ));
            }
            $code = (int) $code;
        }

        if (!is_string($reasonPhrase)) {
            throw new InvalidArgumentException(sprintf(
                'Response reason phrase is not valid. Must be a string, received `%s`.',
                (is_object($reasonPhrase) ? get_class($reasonPhrase) : gettype($reasonPhrase))
            ));
        }

        if ($code === $this->statusCode && $reasonPhrase === $this->reasonPhrase) {
            return $this;
        }

        $new = clone $this;
        $new->setStatus($code, $reasonPhrase);
        return $new;
    }

    /**
     * Gets the response reason phrase associated with the status code.
     *
     * Because a reason phrase is not a required element in a response
     * status line, the reason phrase value MAY be null. Implementations MAY
     * choose to return the default RFC 7231 recommended reason phrase (or those
     * listed in the IANA HTTP Status Code Registry) for the response's
     * status code.
     *
     * @link http://tools.ietf.org/html/rfc7231#section-6
     * @link http://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml
     * @return string Reason phrase; must return an empty string if none present.
     */
    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
    }

    /**
     * @param int $statusCode
     * @param string $reasonPhrase
     * @param StreamInterface|string|resource $body
     * @param array $headers
     * @param string $protocol
     */
    private function init(
        int $statusCode = ResponseStatusCodeInterface::STATUS_OK,
        string $reasonPhrase = '',
        $body = 'php://temp',
        array $headers = [],
        string $protocol = '1.1'
    ): void {
        $this->setStatus($statusCode, $reasonPhrase);
        $this->stream = StreamFactory::create($body);
        $this->registerHeaders($headers);
        $this->registerProtocolVersion($protocol);
    }

    /**
     * @param int $statusCode
     * @param string $reasonPhrase
     * @throws InvalidArgumentException for invalid status code arguments.
     * @link https://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml
     */
    private function setStatus(int $statusCode, string $reasonPhrase = ''): void
    {
        if ($statusCode < 100 || $statusCode > 599) {
            throw new InvalidArgumentException(sprintf(
                'Response status code `%d` is not valid. Must be in the range from 100 to 599 enabled.',
                $statusCode
            ));
        }

        $this->statusCode = $statusCode;
        $this->reasonPhrase = $reasonPhrase ?: (ResponseStatusCodeInterface::PHRASES[$statusCode] ?? '');
    }

    /**
     * @param string $contentType
     */
    private function setContentTypeHeaderIfNotExists(string $contentType): void
    {
        if (!$this->hasHeader('content-type')) {
            $this->headerNames['content-type'] = 'Content-Type';
            $this->headers[$this->headerNames['content-type']] = [$contentType];
        }
    }
}
