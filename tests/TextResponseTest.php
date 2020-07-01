<?php

declare(strict_types=1);

namespace HttpSoft\Tests\Response;

use InvalidArgumentException;
use HttpSoft\Response\TextResponse;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;
use stdClass;

use function array_merge;

class TextResponseTest extends TestCase
{
    /**
     * @var string
     */
    private string $content = 'Text';

    /**
     * @var string
     */
    private string $contentType = 'text/plain; charset=UTF-8';

    /**
     * @var TextResponse
     */
    private TextResponse $response;

    public function setUp(): void
    {
        $this->response = new TextResponse($this->content);
    }

    public function testGettersDefault(): void
    {
        self::assertEquals(TextResponse::STATUS_OK, $this->response->getStatusCode());
        self::assertEquals(TextResponse::PHRASES[TextResponse::STATUS_OK], $this->response->getReasonPhrase());
        self::assertInstanceOf(StreamInterface::class, $this->response->getBody());
        self::assertEquals('php://temp', $this->response->getBody()->getMetadata('uri'));
        self::assertEquals($this->content, $this->response->getBody()->getContents());
        self::assertEquals($this->contentType, $this->response->getHeaderLine('content-type'));
        self::assertEquals('1.1', $this->response->getProtocolVersion());
    }

    public function testGettersSpecifiedArguments(): void
    {
        $response = new TextResponse(
            $this->content,
            $statusCode = TextResponse::STATUS_NOT_FOUND,
            ['Content-Language' => 'en'],
            $protocol = '2',
            $reasonPhrase = TextResponse::PHRASES[TextResponse::STATUS_NOT_FOUND]
        );
        self::assertEquals($this->content, $response->getBody()->getContents());
        self::assertEquals($statusCode, $response->getStatusCode());
        self::assertEquals($reasonPhrase, $response->getReasonPhrase());
        self::assertInstanceOf(StreamInterface::class, $response->getBody());
        self::assertEquals(
            [
                'Content-Language' => ['en'],
                'Content-Type' => [$this->contentType],
            ],
            $response->getHeaders()
        );
        self::assertEquals($protocol, $response->getProtocolVersion());
    }

    public function testGettersIfHasBeenPassedContentTypeHeader(): void
    {
        $response = new TextResponse(
            $this->content,
            $statusCode = TextResponse::STATUS_NOT_FOUND,
            ['Content-Language' => 'en',  'Content-Type' => 'text/plain; charset=UTF-8'],
            $protocol = '2',
            $reasonPhrase = TextResponse::PHRASES[TextResponse::STATUS_NOT_FOUND]
        );
        self::assertEquals($this->content, $response->getBody()->getContents());
        self::assertEquals($statusCode, $response->getStatusCode());
        self::assertEquals($reasonPhrase, $response->getReasonPhrase());
        self::assertInstanceOf(StreamInterface::class, $response->getBody());
        self::assertEquals(
            [
                'Content-Language' => ['en'],
                'Content-Type' => ['text/plain; charset=UTF-8'],
            ],
            $response->getHeaders()
        );
        self::assertEquals($protocol, $response->getProtocolVersion());
    }

    public function testWithStatus(): void
    {
        $response = $this->response->withStatus(TextResponse::STATUS_NOT_FOUND);
        self::assertNotEquals($this->response, $response);
        self::assertEquals(TextResponse::STATUS_NOT_FOUND, $response->getStatusCode());
        self::assertEquals(TextResponse::PHRASES[TextResponse::STATUS_NOT_FOUND], $response->getReasonPhrase());
    }

    public function testWithStatusAndCustomReasonPhrase(): void
    {
        $response = $this->response->withStatus(TextResponse::STATUS_NOT_FOUND, $customPhrase = 'Custom Phrase');
        self::assertNotEquals($this->response, $response);
        self::assertEquals(TextResponse::STATUS_NOT_FOUND, $response->getStatusCode());
        self::assertEquals($customPhrase, $response->getReasonPhrase());
    }

    public function testWithStatusHasNotBeenChangedCodeAndHasBeenChangedReasonPhrase(): void
    {
        $response = $this->response->withStatus(TextResponse::STATUS_OK, $customPhrase = 'Custom Phrase');
        self::assertNotEquals($this->response, $response);
        self::assertEquals(TextResponse::STATUS_OK, $response->getStatusCode());
        self::assertEquals($customPhrase, $response->getReasonPhrase());
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
        $this->response->withStatus(TextResponse::STATUS_OK, $reasonPhrase);
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
