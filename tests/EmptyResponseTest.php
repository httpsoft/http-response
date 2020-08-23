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
        $this->assertSame(EmptyResponse::STATUS_NO_CONTENT, $this->response->getStatusCode());
        $this->assertSame('No Content', $this->response->getReasonPhrase());
        $this->assertInstanceOf(StreamInterface::class, $this->response->getBody());
        $this->assertSame('php://temp', $this->response->getBody()->getMetadata('uri'));
        $this->assertSame('', $this->response->getBody()->getContents());
        $this->assertSame([], $this->response->getHeaders());
        $this->assertSame('1.1', $this->response->getProtocolVersion());
    }

    public function testGettersWithSpecifiedArguments(): void
    {
        $response = new EmptyResponse(
            $statusCode = EmptyResponse::STATUS_CREATED,
            $headers = ['Content-Language' => 'en'],
            $protocol = '2',
            $reasonPhrase = 'Custom Phrase',
        );
        $this->assertSame($statusCode, $response->getStatusCode());
        $this->assertSame($reasonPhrase, $response->getReasonPhrase());
        $this->assertInstanceOf(StreamInterface::class, $response->getBody());
        $this->assertSame('php://temp', $response->getBody()->getMetadata('uri'));
        $this->assertSame(['Content-Language' => ['en']], $response->getHeaders());
        $this->assertSame($protocol, $response->getProtocolVersion());
    }

    public function testWithStatus(): void
    {
        $response = $this->response->withStatus(EmptyResponse::STATUS_CREATED);
        $this->assertNotSame($this->response, $response);
        $this->assertSame(EmptyResponse::STATUS_CREATED, $response->getStatusCode());
        $this->assertSame('Created', $response->getReasonPhrase());
    }

    public function testWithStatusAndCustomReasonPhrase(): void
    {
        $response = $this->response->withStatus(EmptyResponse::STATUS_CREATED, $customPhrase = 'Custom Phrase');
        $this->assertNotSame($this->response, $response);
        $this->assertSame(EmptyResponse::STATUS_CREATED, $response->getStatusCode());
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
