<?php


namespace Tests\Infrastructure\Http;


use Dflydev\FigCookies\FigResponseCookies;
use Infrastructure\Http\Middleware\CookieMiddleware;
use Slim\Http\Request;
use Slim\Http\Response;
use Tests\Infrastructure\Base;

class CookieMiddlewareTest extends Base
{
    public function testInvoke()
    {
        $middleware = new CookieMiddleware();
        $request = $this->requestFactory();
        $response = new Response();

        $next = function(Request $request, Response $response) {
            return $response;
        };

        $response = $middleware($request, $response, $next);

        $cookie = FigResponseCookies::get($response, 'language');

        $this->assertEquals('en_CA', $cookie->getValue());
    }
}