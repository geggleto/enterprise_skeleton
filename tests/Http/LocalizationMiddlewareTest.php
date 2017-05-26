<?php


namespace Tests\Infrastructure\Http;


use Aura\Intl\TranslatorLocator;
use Infrastructure\Http\Middleware\LocalizationMiddleware;
use Slim\Http\Request;
use Slim\Http\Response;
use Tests\Infrastructure\Base;

class LocalizationMiddlewareTest extends Base
{
    public function testInvoke()
    {
        /** @var $locator TranslatorLocator */
        $locator = \Mockery::mock(TranslatorLocator::class)
            ->shouldReceive('setLocale')
            ->once()
            ->withArgs(['en_CA'])
            ->andReturn()
            ->getMock();

        $middleware = new LocalizationMiddleware($locator, ['en_CA']);

        $request = $this->requestFactory();
        $response = new Response();
        $next = function (Request $request, Response $response) {
            return $response->write('');
        };

        $response = $middleware->__invoke($request, $response, $next);
    }

    public function testInvokeWithIncorrectLang()
    {
        /** @var $locator TranslatorLocator */
        $locator = \Mockery::mock(TranslatorLocator::class)
            ->shouldReceive('setLocale')
            ->once()
            ->withArgs(['en_CA'])
            ->andReturn()
            ->getMock();

        $middleware = new LocalizationMiddleware($locator, ['fr_CA']);

        $request = $this->requestFactory();
        $response = new Response();
        $next = function (Request $request, Response $response) {
            return $response->write('');
        };

        $response = $middleware->__invoke($request, $response, $next);
    }
}