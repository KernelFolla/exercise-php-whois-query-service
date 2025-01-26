<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Http\Controller;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Http\Controller\WhoisController;
use App\Application\Service\WhoisService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class WhoisControllerTest extends TestCase
{
    public function testInvokeSuccess()
    {
        $whoisService = $this->createMock(WhoisService::class);
        $whoisService->method('execute')->willReturn(['domain' => 'example.com', 'status' => 'available']);

        $controller = new WhoisController($whoisService);

        $request = $this->createMock(ServerRequestInterface::class);
        $response = $this->createMock(ResponseInterface::class);
        $responseBody = $this->createMock(\Psr\Http\Message\StreamInterface::class);
        $response->method('getBody')->willReturn($responseBody);

        $args = ['domain' => 'example.com'];

        $responseBody->expects($this->once())->method('write')->with(json_encode(['domain' => 'example.com', 'status' => 'available']));
        $response->expects($this->once())->method('withHeader')->with('Content-Type', 'application/json')->willReturnSelf();
        $response->expects($this->once())->method('withStatus')->with(200)->willReturnSelf();

        $result = $controller($request, $response, $args);

        $this->assertSame($response, $result);
    }

    public function testInvokeInvalidArgument()
    {
        $whoisService = $this->createMock(WhoisService::class);
        $whoisService->method('execute')->willThrowException(new \InvalidArgumentException('Invalid domain'));

        $controller = new WhoisController($whoisService);

        $request = $this->createMock(ServerRequestInterface::class);
        $response = $this->createMock(ResponseInterface::class);
        $responseBody = $this->createMock(\Psr\Http\Message\StreamInterface::class);
        $response->method('getBody')->willReturn($responseBody);

        $args = ['domain' => 'invalid_domain'];

        $responseBody->expects($this->once())->method('write')->with(json_encode(['error' => 'Invalid domain']));
        $response->expects($this->once())->method('withHeader')->with('Content-Type', 'application/json')->willReturnSelf();
        $response->expects($this->once())->method('withStatus')->with(400)->willReturnSelf();

        $result = $controller($request, $response, $args);

        $this->assertSame($response, $result);
    }
}