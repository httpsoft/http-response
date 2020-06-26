<?php

declare(strict_types=1);

namespace HttpSoft\Tests\Response;

use InvalidArgumentException;
use HttpSoft\Response\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;
use stdClass;

use function array_merge;

class ResponseTest extends TestCase
{
    /**
     * @var Response
     */
    private Response $response;

    public function setUp(): void
    {
        $this->response = new Response();
    }

    public function testGettersDefault(): void
    {
        self::assertEquals(Response::STATUS_OK, $this->response->getStatusCode());
        self::assertEquals(Response::PHRASES[Response::STATUS_OK], $this->response->getReasonPhrase());
        self::assertInstanceOf(StreamInterface::class, $this->response->getBody());
        self::assertEquals('php://temp', $this->response->getBody()->getMetadata('uri'));
        self::assertEquals('', $this->response->getBody()->getContents());
        self::assertEquals([], $this->response->getHeaders());
        self::assertEquals('1.1', $this->response->getProtocolVersion());
    }

    public function testGettersNotDefault(): void
    {
        $response = new Response(
            $statusCode = Response::STATUS_NOT_FOUND,
            $reasonPhrase = Response::PHRASES[Response::STATUS_NOT_FOUND],
            $stream = 'php://memory',
            ['Host' => 'example.com'],
            $protocol = '2'
        );
        self::assertEquals($statusCode, $response->getStatusCode());
        self::assertEquals($reasonPhrase, $response->getReasonPhrase());
        self::assertInstanceOf(StreamInterface::class, $response->getBody());
        self::assertEquals($stream, $response->getBody()->getMetadata('uri'));
        self::assertEquals('', $response->getBody()->getContents());
        self::assertEquals(['Host' => ['example.com']], $response->getHeaders());
        self::assertEquals($protocol, $response->getProtocolVersion());
    }

    public function testWithStatus(): void
    {
        $response = $this->response->withStatus(Response::STATUS_NOT_FOUND);
        self::assertNotEquals($this->response, $response);
        self::assertEquals(Response::STATUS_NOT_FOUND, $response->getStatusCode());
        self::assertEquals(Response::PHRASES[Response::STATUS_NOT_FOUND], $response->getReasonPhrase());
    }

    public function testWithStatusAndCustomReasonPhrase(): void
    {
        $response = $this->response->withStatus(Response::STATUS_NOT_FOUND, $customPhrase = 'Custom Phrase');
        self::assertNotEquals($this->response, $response);
        self::assertEquals(Response::STATUS_NOT_FOUND, $response->getStatusCode());
        self::assertEquals($customPhrase, $response->getReasonPhrase());
    }

    public function testWithStatusHasNotBeenChangedCodeAndHasBeenChangedReasonPhrase(): void
    {
        $response = $this->response->withStatus(Response::STATUS_OK, $customPhrase = 'Custom Phrase');
        self::assertNotEquals($this->response, $response);
        self::assertEquals(Response::STATUS_OK, $response->getStatusCode());
        self::assertEquals($customPhrase, $response->getReasonPhrase());
    }

    public function testWithStatusHasNotBeenChangedNotClone(): void
    {
        $response = $this->response->withStatus(Response::STATUS_OK, Response::PHRASES[Response::STATUS_OK]);
        self::assertEquals($this->response, $response);
        self::assertEquals(Response::STATUS_OK, $response->getStatusCode());
        self::assertEquals(Response::PHRASES[Response::STATUS_OK], $response->getReasonPhrase());
    }

    public function testWithStatusPassingOnlyCodeHasNotBeenChangedNotClone(): void
    {
        $response = $this->response->withStatus(Response::STATUS_OK);
        self::assertEquals($this->response, $response);
        self::assertEquals(Response::STATUS_OK, $response->getStatusCode());
        self::assertEquals(Response::PHRASES[Response::STATUS_OK], $response->getReasonPhrase());
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
        $this->response->withStatus(Response::STATUS_OK, $reasonPhrase);
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
