<?php

declare(strict_types=1);

namespace HttpSoft\Tests\Response;

use InvalidArgumentException;
use HttpSoft\Response\JsonResponse;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;
use stdClass;

use function array_merge;
use function json_encode;
use function fopen;

class JsonResponseTest extends TestCase
{
    /**
     * @var array
     */
    private array $data = ['key' => 'value'];

    /**
     * @var string
     */
    private string $contentType = 'application/json; charset=UTF-8';

    /**
     * @var JsonResponse
     */
    private JsonResponse $response;

    public function setUp(): void
    {
        $this->response = new JsonResponse($this->data);
    }

    public function testGettersDefault(): void
    {
        self::assertEquals(JsonResponse::STATUS_OK, $this->response->getStatusCode());
        self::assertEquals(JsonResponse::PHRASES[JsonResponse::STATUS_OK], $this->response->getReasonPhrase());
        self::assertInstanceOf(StreamInterface::class, $this->response->getBody());
        self::assertEquals('php://temp', $this->response->getBody()->getMetadata('uri'));
        self::assertEquals(
            json_encode($this->data, JsonResponse::DEFAULT_OPTIONS),
            $this->response->getBody()->getContents()
        );
        self::assertEquals($this->contentType, $this->response->getHeaderLine('content-type'));
        self::assertEquals('1.1', $this->response->getProtocolVersion());
    }

    public function testGettersIfHasBeenPassedContentTypeHeader(): void
    {
        $response = new JsonResponse(
            $this->data,
            $statusCode = JsonResponse::STATUS_NOT_FOUND,
            ['Content-Language' => 'en',  'Content-Type' => 'text/plain; charset=UTF-8'],
            $protocol = '2',
            $reasonPhrase = JsonResponse::PHRASES[JsonResponse::STATUS_NOT_FOUND]
        );
        self::assertEquals(
            json_encode($this->data, JsonResponse::DEFAULT_OPTIONS),
            $this->response->getBody()->getContents()
        );
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

    public function testGettersSpecifiedArgumentsWithHtmlEncodingOptions(): void
    {
        $response = new JsonResponse(
            $data = ['html' => '<p>HTML</p>'],
            $statusCode = JsonResponse::STATUS_NOT_FOUND,
            ['Content-Language' => 'en'],
            $protocol = '2',
            $reasonPhrase = JsonResponse::PHRASES[JsonResponse::STATUS_NOT_FOUND],
            $encodingOptions = JsonResponse::HTML_OPTIONS
        );
        self::assertEquals(json_encode($data, $encodingOptions), $response->getBody()->getContents());
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

    public function testWithJsonDataWithHtmlEncodingOptions(): void
    {
        $response = $this->response->withJsonData(
            $data = ['html' => '<p>HTML</p>'],
            $encodingOptions = JsonResponse::HTML_OPTIONS
        );
        self::assertNotEquals($response, $this->response);
        self::assertEquals(json_encode($data, $encodingOptions), $response->getBody()->getContents());
        self::assertEquals(JsonResponse::STATUS_OK, $response->getStatusCode());
        self::assertEquals(JsonResponse::PHRASES[JsonResponse::STATUS_OK], $response->getReasonPhrase());
        self::assertInstanceOf(StreamInterface::class, $response->getBody());
        self::assertEquals(['Content-Type' => [$this->contentType]], $response->getHeaders());
        self::assertEquals('1.1', $response->getProtocolVersion());
    }

    public function testGettersSpecifiedArgumentsWithCustomEncodingOptions(): void
    {
        $response = new JsonResponse(
            $data = ['text' => "O'Reilly"],
            $statusCode = JsonResponse::STATUS_NOT_FOUND,
            ['Content-Language' => 'en'],
            $protocol = '2',
            $reasonPhrase = JsonResponse::PHRASES[JsonResponse::STATUS_NOT_FOUND],
            $encodingOptions = JSON_HEX_APOS | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
        );
        self::assertEquals(json_encode($data, $encodingOptions), $response->getBody()->getContents());
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

    public function testWithJsonDataWithCustomEncodingOptions(): void
    {
        $response = $this->response->withJsonData(
            $data = ['text' => "O'Reilly"],
            $encodingOptions = JSON_HEX_APOS | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
        );
        self::assertNotEquals($response, $this->response);
        self::assertEquals(json_encode($data, $encodingOptions), $response->getBody()->getContents());
        self::assertEquals(JsonResponse::STATUS_OK, $response->getStatusCode());
        self::assertEquals(JsonResponse::PHRASES[JsonResponse::STATUS_OK], $response->getReasonPhrase());
        self::assertInstanceOf(StreamInterface::class, $response->getBody());
        self::assertEquals(['Content-Type' => [$this->contentType]], $response->getHeaders());
        self::assertEquals('1.1', $response->getProtocolVersion());
    }

    public function testWithJsonDataHasBeenClonedForSpecifiedObjectData(): void
    {
        $data = new StdClass();
        $response = $this->response->withJsonData($data);
        self::assertNotEquals($response, $this->response);
        $response2 = $response->withJsonData($data);
        self::assertNotEquals($response2, $response);
        $response3 = $response2->withJsonData($data);
        self::assertNotEquals($response3, $response2);
        self::assertNotEquals($response3, $response);
    }

    /**
     * @return array
     */
    public function invalidDataProvider(): array
    {
        return [
            'invalid-UTF8-sequence' => ["\xB1\x31"],
            'resource' => [fopen('php://memory', 'r')],
        ];
    }

    /**
     * @dataProvider invalidDataProvider
     * @param mixed $data
     */
    public function testConstructorThrowExceptionForInvalidData($data): void
    {
        $this->expectException(InvalidArgumentException::class);
        new JsonResponse($data);
    }

    /**
     * @dataProvider invalidDataProvider
     * @param mixed $data
     */
    public function testWithJsonDataThrowExceptionForInvalidData($data): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->response->withJsonData($data);
    }

    /**
     * @dataProvider invalidDataProvider
     * @param mixed $data
     */
    public function testConstructorThrowExceptionForInvalidDataWithThrowOnErrorOption($data): void
    {
        $this->expectException(InvalidArgumentException::class);
        new JsonResponse($data, JsonResponse::STATUS_OK, [], '1.1', '', JSON_THROW_ON_ERROR);
    }

    /**
     * @dataProvider invalidDataProvider
     * @param mixed $data
     */
    public function testWithJsonDataThrowExceptionForInvalidDataWithThrowOnErrorOption($data): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->response->withJsonData($data, JSON_THROW_ON_ERROR);
    }

    /**
     * @return array
     */
    public function validDataProvider(): array
    {
        return $this->getProviderValues(['string' => ['string']]);
    }

    /**
     * @dataProvider validDataProvider
     * @param mixed $data
     */
    public function testConstructorForValidBody($data): void
    {
        $response = new JsonResponse($data);
        self::assertEquals(JsonResponse::STATUS_OK, $response->getStatusCode());
        self::assertEquals(JsonResponse::PHRASES[JsonResponse::STATUS_OK], $response->getReasonPhrase());
        self::assertEquals(json_encode($data, JsonResponse::DEFAULT_OPTIONS), $response->getBody()->getContents());
        self::assertEquals($this->contentType, $response->getHeaderLine('content-type'));
    }

    public function testWithStatus(): void
    {
        $response = $this->response->withStatus(JsonResponse::STATUS_NOT_FOUND);
        self::assertNotEquals($this->response, $response);
        self::assertEquals(JsonResponse::STATUS_NOT_FOUND, $response->getStatusCode());
        self::assertEquals(JsonResponse::PHRASES[JsonResponse::STATUS_NOT_FOUND], $response->getReasonPhrase());
    }

    public function testWithStatusAndCustomReasonPhrase(): void
    {
        $response = $this->response->withStatus(JsonResponse::STATUS_NOT_FOUND, $customPhrase = 'Custom Phrase');
        self::assertNotEquals($this->response, $response);
        self::assertEquals(JsonResponse::STATUS_NOT_FOUND, $response->getStatusCode());
        self::assertEquals($customPhrase, $response->getReasonPhrase());
    }

    public function testWithStatusHasNotBeenChangedCodeAndHasBeenChangedReasonPhrase(): void
    {
        $response = $this->response->withStatus(JsonResponse::STATUS_OK, $customPhrase = 'Custom Phrase');
        self::assertNotEquals($this->response, $response);
        self::assertEquals(JsonResponse::STATUS_OK, $response->getStatusCode());
        self::assertEquals($customPhrase, $response->getReasonPhrase());
    }

    public function testWithStatusHasNotBeenChangedNotClone(): void
    {
        $response = $this->response->withStatus(
            JsonResponse::STATUS_OK,
            JsonResponse::PHRASES[JsonResponse::STATUS_OK]
        );
        self::assertEquals($this->response, $response);
        self::assertEquals(JsonResponse::STATUS_OK, $response->getStatusCode());
        self::assertEquals(JsonResponse::PHRASES[JsonResponse::STATUS_OK], $response->getReasonPhrase());
    }

    public function testWithStatusPassingOnlyCodeHasNotBeenChangedNotClone(): void
    {
        $response = $this->response->withStatus(JsonResponse::STATUS_OK);
        self::assertEquals($this->response, $response);
        self::assertEquals(JsonResponse::STATUS_OK, $response->getStatusCode());
        self::assertEquals(JsonResponse::PHRASES[JsonResponse::STATUS_OK], $response->getReasonPhrase());
    }

    /**
     * @return array
     */
    public function invalidStatusCodeProvider(): array
    {
        return $this->getProviderValues(['status-code-less' => [99], 'status-code-more' => [600]]);
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
        return $this->getProviderValues(['status-code' => [200]]);
    }

    /**
     * @dataProvider invalidStatusReasonPhraseProvider
     * @param mixed $reasonPhrase
     */
    public function testWithStatusThrowExceptionForInvalidReasonPhrase($reasonPhrase): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->response->withStatus(JsonResponse::STATUS_OK, $reasonPhrase);
    }

    /**
     * @param array $values
     * @return array
     */
    private function getProviderValues(array $values = []): array
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
