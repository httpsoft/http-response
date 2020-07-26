<?php

declare(strict_types=1);

namespace HttpSoft\Tests\Response;

use HttpSoft\Response\Response;
use HttpSoft\Response\ResponseFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ResponseFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $response = ResponseFactory::create();
        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame(Response::STATUS_OK, $response->getStatusCode());
        $this->assertSame(Response::PHRASES[Response::STATUS_OK], $response->getReasonPhrase());
        $this->assertInstanceOf(StreamInterface::class, $response->getBody());
        $this->assertSame('php://temp', $response->getBody()->getMetadata('uri'));
        $this->assertSame([], $response->getHeaders());
        $this->assertSame('1.1', $response->getProtocolVersion());

        $response = ResponseFactory::create(Response::STATUS_NOT_FOUND);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame(Response::STATUS_NOT_FOUND, $response->getStatusCode());
        $this->assertSame(Response::PHRASES[Response::STATUS_NOT_FOUND], $response->getReasonPhrase());
        $this->assertInstanceOf(StreamInterface::class, $response->getBody());
        $this->assertSame('php://temp', $response->getBody()->getMetadata('uri'));
        $this->assertSame([], $response->getHeaders());
        $this->assertSame('1.1', $response->getProtocolVersion());

        $response = ResponseFactory::create(
            $statusCode = Response::STATUS_NOT_FOUND,
            ['Content-Language' => 'en'],
            $stream = 'php://memory',
            $protocol = '2',
            $customPhrase = 'Custom Phrase'
        );
        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame($statusCode, $response->getStatusCode());
        $this->assertSame($customPhrase, $response->getReasonPhrase());
        $this->assertInstanceOf(StreamInterface::class, $response->getBody());
        $this->assertSame($stream, $response->getBody()->getMetadata('uri'));
        $this->assertSame(['Content-Language' => ['en']], $response->getHeaders());
        $this->assertSame($protocol, $response->getProtocolVersion());
    }

    public function testCreateUri(): void
    {
        $factory = new ResponseFactory();

        $response = $factory->createResponse();
        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame(Response::STATUS_OK, $response->getStatusCode());
        $this->assertSame(Response::PHRASES[Response::STATUS_OK], $response->getReasonPhrase());
        $this->assertInstanceOf(StreamInterface::class, $response->getBody());
        $this->assertSame('php://temp', $response->getBody()->getMetadata('uri'));
        $this->assertSame([], $response->getHeaders());
        $this->assertSame('1.1', $response->getProtocolVersion());

        $response = $factory->createResponse(Response::STATUS_NOT_FOUND);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame(Response::STATUS_NOT_FOUND, $response->getStatusCode());
        $this->assertSame(Response::PHRASES[Response::STATUS_NOT_FOUND], $response->getReasonPhrase());
        $this->assertInstanceOf(StreamInterface::class, $response->getBody());
        $this->assertSame('php://temp', $response->getBody()->getMetadata('uri'));
        $this->assertSame([], $response->getHeaders());
        $this->assertSame('1.1', $response->getProtocolVersion());

        $response = $factory->createResponse(Response::STATUS_NOT_FOUND, $customPhrase = 'Custom Phrase');
        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame(Response::STATUS_NOT_FOUND, $response->getStatusCode());
        $this->assertSame($customPhrase, $response->getReasonPhrase());
        $this->assertInstanceOf(StreamInterface::class, $response->getBody());
        $this->assertSame('php://temp', $response->getBody()->getMetadata('uri'));
        $this->assertSame([], $response->getHeaders());
        $this->assertSame('1.1', $response->getProtocolVersion());
    }
}
