<?php

declare(strict_types=1);

namespace HttpSoft\Tests\Response;

use HttpSoft\Response\RedirectResponse;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;
use stdClass;

use function array_merge;

class RedirectResponseTest extends TestCase
{
    /**
     * @var string
     */
    private string $uri = 'https://example.com/path?query=string#fragment';

    /**
     * @var RedirectResponse
     */
    private RedirectResponse $response;

    public function setUp(): void
    {
        $this->response = new RedirectResponse($this->uri);
    }

    public function testGettersDefault(): void
    {
        $this->assertSame(RedirectResponse::STATUS_FOUND, $this->response->getStatusCode());
        $this->assertSame(
            RedirectResponse::PHRASES[RedirectResponse::STATUS_FOUND],
            $this->response->getReasonPhrase()
        );
        $this->assertInstanceOf(StreamInterface::class, $this->response->getBody());
        $this->assertSame('php://temp', $this->response->getBody()->getMetadata('uri'));
        $this->assertSame($this->uri, $this->response->getHeaderLine('location'));
        $this->assertSame('1.1', $this->response->getProtocolVersion());
    }

    public function testGettersWithStatus301MovedPermanently(): void
    {

        $response = new RedirectResponse(
            $uri = 'https://example.com/path?query=string#fragment',
            $statusCode = RedirectResponse::STATUS_MOVED_PERMANENTLY
        );
        $this->assertSame($statusCode, $response->getStatusCode());
        $this->assertSame(RedirectResponse::PHRASES[$statusCode], $response->getReasonPhrase());
        $this->assertInstanceOf(StreamInterface::class, $response->getBody());
        $this->assertSame('php://temp', $response->getBody()->getMetadata('uri'));
        $this->assertSame($uri, $response->getHeaderLine('location'));
        $this->assertSame('1.1', $response->getProtocolVersion());
    }

    public function testGettersWithSpecifiedArguments(): void
    {
        $response = new RedirectResponse(
            $uri = 'https://example.com/path?query=string#fragment',
            $statusCode = RedirectResponse::STATUS_MOVED_PERMANENTLY,
            $headers = ['Content-Language' => 'en'],
            $protocol = '2',
            $reasonPhrase = 'Custom Phrase',
        );
        $this->assertSame($statusCode, $response->getStatusCode());
        $this->assertSame($reasonPhrase, $response->getReasonPhrase());
        $this->assertInstanceOf(StreamInterface::class, $response->getBody());
        $this->assertSame('php://temp', $response->getBody()->getMetadata('uri'));
        $this->assertSame($uri, $response->getHeaderLine('location'));
        $this->assertSame(['Content-Language' => ['en'], 'Location' => [$uri]], $response->getHeaders());
        $this->assertSame($protocol, $response->getProtocolVersion());
    }

    public function testWithStatus(): void
    {
        $response = $this->response->withStatus(RedirectResponse::STATUS_MOVED_PERMANENTLY);
        $this->assertNotSame($this->response, $response);
        $this->assertSame(RedirectResponse::STATUS_MOVED_PERMANENTLY, $response->getStatusCode());
        $this->assertSame(
            RedirectResponse::PHRASES[RedirectResponse::STATUS_MOVED_PERMANENTLY],
            $response->getReasonPhrase()
        );
    }

    public function testWithStatusAndCustomReasonPhrase(): void
    {
        $response = $this->response->withStatus(
            RedirectResponse::STATUS_MOVED_PERMANENTLY,
            $customPhrase = 'Custom Phrase'
        );
        $this->assertNotSame($this->response, $response);
        $this->assertSame(RedirectResponse::STATUS_MOVED_PERMANENTLY, $response->getStatusCode());
        $this->assertSame($customPhrase, $response->getReasonPhrase());
    }

    public function testWithStatusHasNotBeenChangedCodeAndHasBeenChangedReasonPhrase(): void
    {
        $response = $this->response->withStatus(
            RedirectResponse::STATUS_MOVED_PERMANENTLY,
            $customPhrase = 'Custom Phrase'
        );
        $this->assertNotSame($this->response, $response);
        $this->assertSame(RedirectResponse::STATUS_MOVED_PERMANENTLY, $response->getStatusCode());
        $this->assertSame($customPhrase, $response->getReasonPhrase());
    }

    /**
     * @return array
     */
    public function invalidStatusCodeProvider(): array
    {
        return $this->getInvalidValues(['status-code-less' => [99], 'status-code-more' => [600]]);
    }

    /**
     * @dataProvider invalidStatusCodeProvider
     * @param mixed $code
     */
    public function testWithStatusThrowExceptionForInvalidCode($code): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->response->withStatus($code);
    }

    /**
     * @return array
     */
    public function invalidStatusReasonPhraseProvider(): array
    {
        return $this->getInvalidValues(['status-code' => [200]]);
    }

    /**
     * @dataProvider invalidStatusReasonPhraseProvider
     * @param mixed $reasonPhrase
     */
    public function testWithStatusThrowExceptionForInvalidReasonPhrase($reasonPhrase): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->response->withStatus(RedirectResponse::STATUS_FOUND, $reasonPhrase);
    }

    /**
     * @param array $values
     * @return array
     */
    private function getInvalidValues(array $values = []): array
    {
        $common = [
            'null' => [null],
            'true' => [true],
            'false' => [false],
            'int' => [1],
            'float' => [1.1],
            'array' => [[1, 1.1]],
            'empty-array' => [[]],
            'object' => [new StdClass()],
            'callable' => [fn() => null],
        ];

        if ($values) {
            return array_merge($common, $values);
        }

        return $common;
    }
}
