<?php


namespace Infrastructure\Http\Middleware;



use Dflydev\FigCookies\FigRequestCookies;
use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\SetCookie;
use Infrastructure\ValueObject\Identity\Uuid;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class CookieMiddleware
 * @package Tradesii\Http\Middleware
 *
 * Restricts a route based upon the HTTP REFERER
 */
class CookieMiddleware implements MiddlewareInterface
{
    protected $domain;

    public function __construct($domain = '')
    {
        $this->domain = $domain;
    }

    public function __invoke(Request $serverRequest, Response $response, callable $next)
    {
        $requestCookie = FigRequestCookies::get($serverRequest, 'uid', (string)new Uuid());

        $responseCookie = SetCookie::create('uid', $requestCookie->getValue())
            ->withDomain('.' . $this->domain)
            ->withPath('/')
            ->withHttpOnly(true)
            ->rememberForever();

        $response = FigResponseCookies::set($response, $responseCookie);
        $request = FigRequestCookies::set($serverRequest, $requestCookie);

        $languageRequestCookie = FigRequestCookies::get($request, 'language', 'en_CA');
        $languageResponseCookie = SetCookie::create('language', $languageRequestCookie->getValue())
            ->withDomain('.' . $this->domain)
            ->withPath('/')
            ->withHttpOnly(true)
            ->rememberForever();

        $response = FigResponseCookies::set($response, $languageResponseCookie);
        $request = FigRequestCookies::set($request, $languageRequestCookie);

        return $next($request, $response);
    }
}