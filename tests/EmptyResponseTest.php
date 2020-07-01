<?php

declare(strict_types=1);

namespace HttpSoft\Tests\Response;

use HttpSoft\Response\EmptyResponse;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;
use stdClass;

use function array_merge;

class EmptyResponseTest extends TestCase
{
    /**
     * @var EmptyResponse
     */
    private EmptyResponse $response;

    public function setUp(): void
    {
        $this->response = new EmptyResponse();
    }

    public function testGettersDefault(): void
    {
        self::assertEquals(EmptyResponse::STATUS_NO_CONTENT, $this->response->getStatusCode());
        self::assertEquals(
            EmptyResponse::PHRASES[EmptyResponse::STATUS_NO_CONTENT],
            $this->response->getReasonPhrase()
        );
        self::assertInstanceOf(StreamInterface::class, $this->response->getBody());
        self::assertEquals('php://temp', $this->response->getBody()->getMetadata('uri'));
        self::assertEquals('', $this->response->getBody()->getContents());
        self::assertEquals([], $this->response->getHeaders());
        self::assertEquals('1.1', $this->response->getProtocolVersion());
    }

    public function testGettersWithSpecifiedArguments(): void
    {
        $response = new EmptyResponse(
            $statusCode = EmptyResponse::STATUS_CREATED,
            $headers = ['Content-Language' => 'en'],
            $protocol = '2',
            $reasonPhrase = 'Custom Phrase',
        );
        self::assertEquals($statusCode, $response->getStatusCode());
        self::assertEquals($reasonPhrase, $response->getReasonPhrase());
        self::assertInstanceOf(StreamInterface::class, $response->getBody());
        self::assertEquals('php://temp', $response->getBody()->getMetadata('uri'));
        self::assertEquals(['Content-Language' => ['en']], $response->getHeaders());
        self::assertEquals($protocol, $response->getProtocolVersion());
    }

    public function testWithStatus(): void
    {
        $response = $this->response->withStatus(EmptyResponse::STATUS_CREATED);
        self::assertNotEquals($this->response, $response);
        self::assertEquals(EmptyResponse::STATUS_CREATED, $response->getStatusCode());
        self::assertEquals(EmptyResponse::PHRASES[EmptyResponse::STATUS_CREATED], $response->getReasonPhrase());
    }

    public function testWithStatusAndCustomReasonPhrase(): void
    {
        $response = $this->response->withStatus(EmptyResponse::STATUS_CREATED, $customPhrase = 'Custom Phrase');
        self::assertNotEquals($this->response, $response);
        self::assertEquals(EmptyResponse::STATUS_CREATED, $response->getStatusCode());
        self::assertEquals($customPhrase, $response->getReasonPhrase());
    }

    public function testWithStatusPassingOnlyCodeHasNotBeenChangedNotClone(): void
    {
        $response = $this->response->withStatus(EmptyResponse::STATUS_NO_CONTENT);
        self::assertEquals($this->response, $response);
        self::assertEquals(EmptyResponse::STATUS_NO_CONTENT, $response->getStatusCode());
        self::assertEquals(EmptyResponse::PHRASES[EmptyResponse::STATUS_NO_CONTENT], $response->getReasonPhrase());
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
        $this->response->withStatus(EmptyResponse::STATUS_NO_CONTENT, $reasonPhrase);
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
