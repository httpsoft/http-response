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
        self::assertInstanceOf(Response::class, $response);
        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertEquals(Response::STATUS_OK, $response->getStatusCode());
        self::assertEquals(Response::PHRASES[Response::STATUS_OK], $response->getReasonPhrase());
        self::assertInstanceOf(StreamInterface::class, $response->getBody());
        self::assertEquals('php://temp', $response->getBody()->getMetadata('uri'));
        self::assertEquals([], $response->getHeaders());
        self::assertEquals('1.1', $response->getProtocolVersion());

        $response = ResponseFactory::create(Response::STATUS_NOT_FOUND);
        self::assertInstanceOf(Response::class, $response);
        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertEquals(Response::STATUS_NOT_FOUND, $response->getStatusCode());
        self::assertEquals(Response::PHRASES[Response::STATUS_NOT_FOUND], $response->getReasonPhrase());
        self::assertInstanceOf(StreamInterface::class, $response->getBody());
        self::assertEquals('php://temp', $response->getBody()->getMetadata('uri'));
        self::assertEquals([], $response->getHeaders());
        self::assertEquals('1.1', $response->getProtocolVersion());

        $response = ResponseFactory::create(
            $statusCode = Response::STATUS_NOT_FOUND,
            $customPhrase = 'Custom Phrase',
            $stream = 'php://memory',
            ['Content-Language' => 'en'],
            $protocol = '2'
        );
        self::assertInstanceOf(Response::class, $response);
        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertEquals($statusCode, $response->getStatusCode());
        self::assertEquals($customPhrase, $response->getReasonPhrase());
        self::assertInstanceOf(StreamInterface::class, $response->getBody());
        self::assertEquals($stream, $response->getBody()->getMetadata('uri'));
        self::assertEquals(['Content-Language' => ['en']], $response->getHeaders());
        self::assertEquals($protocol, $response->getProtocolVersion());
    }

    public function testCreateUri(): void
    {
        $factory = new ResponseFactory();

        $response = $factory->createResponse();
        self::assertInstanceOf(Response::class, $response);
        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertEquals(Response::STATUS_OK, $response->getStatusCode());
        self::assertEquals(Response::PHRASES[Response::STATUS_OK], $response->getReasonPhrase());
        self::assertInstanceOf(StreamInterface::class, $response->getBody());
        self::assertEquals('php://temp', $response->getBody()->getMetadata('uri'));
        self::assertEquals([], $response->getHeaders());
        self::assertEquals('1.1', $response->getProtocolVersion());

        $response = $factory->createResponse(Response::STATUS_NOT_FOUND);
        self::assertInstanceOf(Response::class, $response);
        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertEquals(Response::STATUS_NOT_FOUND, $response->getStatusCode());
        self::assertEquals(Response::PHRASES[Response::STATUS_NOT_FOUND], $response->getReasonPhrase());
        self::assertInstanceOf(StreamInterface::class, $response->getBody());
        self::assertEquals('php://temp', $response->getBody()->getMetadata('uri'));
        self::assertEquals([], $response->getHeaders());
        self::assertEquals('1.1', $response->getProtocolVersion());

        $response = $factory->createResponse(Response::STATUS_NOT_FOUND, $customPhrase = 'Custom Phrase');
        self::assertInstanceOf(Response::class, $response);
        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertEquals(Response::STATUS_NOT_FOUND, $response->getStatusCode());
        self::assertEquals($customPhrase, $response->getReasonPhrase());
        self::assertInstanceOf(StreamInterface::class, $response->getBody());
        self::assertEquals('php://temp', $response->getBody()->getMetadata('uri'));
        self::assertEquals([], $response->getHeaders());
        self::assertEquals('1.1', $response->getProtocolVersion());
    }
}
