<?php

declare(strict_types=1);

namespace HttpSoft\Response;

use InvalidArgumentException;
use JsonException;
use Psr\Http\Message\ResponseInterface;

use function is_resource;
use function json_encode;
use function json_last_error;
use function json_last_error_msg;
use function sprintf;

use const JSON_ERROR_NONE;
use const JSON_HEX_AMP;
use const JSON_HEX_APOS;
use const JSON_HEX_QUOT;
use const JSON_HEX_TAG;
use const JSON_UNESCAPED_SLASHES;
use const JSON_UNESCAPED_UNICODE;

final class JsonResponse implements ResponseInterface, ResponseStatusCodeInterface
{
    use ResponseExtensionTrait;

    /**
     * Default options for `json_encode()`.
     */
    public const DEFAULT_OPTIONS = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;

    /**
     * Options for the HTML encoding to `json_encode()`.
     */
    public const HTML_OPTIONS = JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_UNESCAPED_UNICODE;

    /**
     * @param mixed $data
     * @param int $code
     * @param array $headers
     * @param string $protocol
     * @param string $reasonPhrase
     * @param int $encodingOptions
     * @throws InvalidArgumentException If it is impossible to encode the data in JSON.
     */
    public function __construct(
        $data,
        int $code = self::STATUS_OK,
        array $headers = [],
        string $protocol = '1.1',
        string $reasonPhrase = '',
        int $encodingOptions = self::DEFAULT_OPTIONS
    ) {
        $json = $this->encode($data, $encodingOptions);
        $this->init($code, $reasonPhrase, $headers, $this->createBody($json), $protocol);
        $this->setContentTypeHeaderIfNotExists('application/json; charset=UTF-8');
    }

    /**
     * @param mixed $data
     * @param int $encodingOptions
     * @return self
     */
    public function withJsonData($data, int $encodingOptions = self::DEFAULT_OPTIONS): self
    {
        return $this->withBody($this->createBody($this->encode($data, $encodingOptions)));
    }

    /**
     * @param mixed $data
     * @param int $options
     * @return string
     * @throws InvalidArgumentException If it is impossible to encode the data in JSON.
     */
    private function encode($data, int $options): string
    {
        if (is_resource($data)) {
            throw new InvalidArgumentException('Resources cannot be encoded in JSON.');
        }

        try {
            /** @psalm-suppress UnusedFunctionCall */
            json_encode(null);
            $json = json_encode($data, $options);

            if (JSON_ERROR_NONE !== json_last_error()) {
                throw new JsonException(json_last_error_msg());
            }

            return $json;
        } catch (JsonException $e) {
            throw new InvalidArgumentException(sprintf('Unable to encode data to JSON: `%s`', $e->getMessage()));
        }
    }
}
