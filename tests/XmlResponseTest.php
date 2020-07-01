<?php

declare(strict_types=1);

namespace HttpSoft\Tests\Response;

use InvalidArgumentException;
use HttpSoft\Response\XmlResponse;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;
use stdClass;

use function array_merge;

class XmlResponseTest extends TestCase
{
    /**
     * @var string
     */
    private string $content = '<?xml version="1.0"?>' . PHP_EOL . '<xmltag>XML</xmltag>';

    /**
     * @var string
     */
    private string $contentType = 'application/xml; charset=UTF-8';

    /**
     * @var XmlResponse
     */
    private XmlResponse $response;

    public function setUp(): void
    {
        $this->response = new XmlResponse($this->content);
    }

    public function testGettersDefault(): void
    {
        self::assertEquals(XmlResponse::STATUS_OK, $this->response->getStatusCode());
        self::assertEquals(XmlResponse::PHRASES[XmlResponse::STATUS_OK], $this->response->getReasonPhrase());
        self::assertInstanceOf(StreamInterface::class, $this->response->getBody());
        self::assertEquals('php://temp', $this->response->getBody()->getMetadata('uri'));
        self::assertEquals($this->content, $this->response->getBody()->getContents());
        self::assertEquals($this->contentType, $this->response->getHeaderLine('content-type'));
        self::assertEquals('1.1', $this->response->getProtocolVersion());
    }

    public function testGettersSpecifiedArguments(): void
    {
        $response = new XmlResponse(
            $this->content,
            $statusCode = XmlResponse::STATUS_NOT_FOUND,
            ['Content-Language' => 'en'],
            $protocol = '2',
            $reasonPhrase = XmlResponse::PHRASES[XmlResponse::STATUS_NOT_FOUND]
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
        $response = new XmlResponse(
            $this->content,
            $statusCode = XmlResponse::STATUS_NOT_FOUND,
            ['Content-Language' => 'en',  'Content-Type' => 'text/plain; charset=UTF-8'],
            $protocol = '2',
            $reasonPhrase = XmlResponse::PHRASES[XmlResponse::STATUS_NOT_FOUND]
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
        $response = $this->response->withStatus(XmlResponse::STATUS_NOT_FOUND);
        self::assertNotEquals($this->response, $response);
        self::assertEquals(XmlResponse::STATUS_NOT_FOUND, $response->getStatusCode());
        self::assertEquals(XmlResponse::PHRASES[XmlResponse::STATUS_NOT_FOUND], $response->getReasonPhrase());
    }

    public function testWithStatusAndCustomReasonPhrase(): void
    {
        $response = $this->response->withStatus(XmlResponse::STATUS_NOT_FOUND, $customPhrase = 'Custom Phrase');
        self::assertNotEquals($this->response, $response);
        self::assertEquals(XmlResponse::STATUS_NOT_FOUND, $response->getStatusCode());
        self::assertEquals($customPhrase, $response->getReasonPhrase());
    }

    public function testWithStatusHasNotBeenChangedCodeAndHasBeenChangedReasonPhrase(): void
    {
        $response = $this->response->withStatus(XmlResponse::STATUS_OK, $customPhrase = 'Custom Phrase');
        self::assertNotEquals($this->response, $response);
        self::assertEquals(XmlResponse::STATUS_OK, $response->getStatusCode());
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
        $this->response->withStatus(XmlResponse::STATUS_OK, $reasonPhrase);
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
