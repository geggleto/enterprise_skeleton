<?php


namespace Tests\Infrastructure\Http;


use Infrastructure\Http\Middleware\ApiLogMiddleware;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Tests\Infrastructure\Base;

class ApiLoggerMiddlewareTest extends Base
{
    public function testInvoke()
    {
        /** @var $logger LoggerInterface */
        $logger = \Mockery::mock(LoggerInterface::class)
            ->shouldReceive('emergency')
            ->withAnyArgs()
            ->andReturn()
            ->getMock();

        $middleware = new ApiLogMiddleware($logger);
        $request = $this->requestFactory();
        $response = new Response();

        $next = function(Request $request, Response $response) {
            return $response->withStatus(500);
        };

        $response = $middleware($request, $response, $next);

        $this->assertEquals(500, $response->getStatusCode());
    }
}