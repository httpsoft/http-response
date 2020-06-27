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
        self::assertEquals(RedirectResponse::STATUS_FOUND, $this->response->getStatusCode());
        self::assertEquals(
            RedirectResponse::PHRASES[RedirectResponse::STATUS_FOUND],
            $this->response->getReasonPhrase()
        );
        self::assertInstanceOf(StreamInterface::class, $this->response->getBody());
        self::assertEquals('php://temp', $this->response->getBody()->getMetadata('uri'));
        self::assertEquals($this->uri, $this->response->getHeaderLine('location'));
        self::assertEquals('1.1', $this->response->getProtocolVersion());
    }

    public function testGettersWithStatus301MovedPermanently(): void
    {

        $response = new RedirectResponse(
            $uri = 'https://example.com/path?query=string#fragment',
            $statusCode = RedirectResponse::STATUS_MOVED_PERMANENTLY
        );
        self::assertEquals($statusCode, $response->getStatusCode());
        self::assertEquals(RedirectResponse::PHRASES[$statusCode], $response->getReasonPhrase());
        self::assertInstanceOf(StreamInterface::class, $response->getBody());
        self::assertEquals('php://temp', $response->getBody()->getMetadata('uri'));
        self::assertEquals($uri, $response->getHeaderLine('location'));
        self::assertEquals('1.1', $response->getProtocolVersion());
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
        self::assertEquals($statusCode, $response->getStatusCode());
        self::assertEquals($reasonPhrase, $response->getReasonPhrase());
        self::assertInstanceOf(StreamInterface::class, $response->getBody());
        self::assertEquals('php://temp', $response->getBody()->getMetadata('uri'));
        self::assertEquals($uri, $response->getHeaderLine('location'));
        self::assertEquals(['Content-Language' => ['en'], 'Location' => [$uri]], $response->getHeaders());
        self::assertEquals($protocol, $response->getProtocolVersion());
    }

    public function testWithStatus(): void
    {
        $response = $this->response->withStatus(RedirectResponse::STATUS_MOVED_PERMANENTLY);
        self::assertNotEquals($this->response, $response);
        self::assertEquals(RedirectResponse::STATUS_MOVED_PERMANENTLY, $response->getStatusCode());
        self::assertEquals(
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
        self::assertNotEquals($this->response, $response);
        self::assertEquals(RedirectResponse::STATUS_MOVED_PERMANENTLY, $response->getStatusCode());
        self::assertEquals($customPhrase, $response->getReasonPhrase());
    }

    public function testWithStatusHasNotBeenChangedCodeAndHasBeenChangedReasonPhrase(): void
    {
        $response = $this->response->withStatus(
            RedirectResponse::STATUS_MOVED_PERMANENTLY,
            $customPhrase = 'Custom Phrase'
        );
        self::assertNotEquals($this->response, $response);
        self::assertEquals(RedirectResponse::STATUS_MOVED_PERMANENTLY, $response->getStatusCode());
        self::assertEquals($customPhrase, $response->getReasonPhrase());
    }

    public function testWithStatusHasNotBeenChangedNotClone(): void
    {
        $response = $this->response->withStatus(
            RedirectResponse::STATUS_FOUND,
            RedirectResponse::PHRASES[RedirectResponse::STATUS_FOUND]
        );
        self::assertEquals($this->response, $response);
        self::assertEquals(RedirectResponse::STATUS_FOUND, $response->getStatusCode());
        self::assertEquals(RedirectResponse::PHRASES[RedirectResponse::STATUS_FOUND], $response->getReasonPhrase());
    }

    public function testWithStatusPassingOnlyCodeHasNotBeenChangedNotClone(): void
    {
        $response = $this->response->withStatus(RedirectResponse::STATUS_FOUND);
        self::assertEquals($this->response, $response);
        self::assertEquals(RedirectResponse::STATUS_FOUND, $response->getStatusCode());
        self::assertEquals(RedirectResponse::PHRASES[RedirectResponse::STATUS_FOUND], $response->getReasonPhrase());
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
