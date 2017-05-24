<?php
namespace Infrastructure\Http\Middleware;


use Slim\Http\Request;
use Slim\Http\Response;

interface MiddlewareInterface
{
    /**
     * @param Request $serverRequest
     * @param Response $response
     * @param callable $next
     *
     * @return Response
     */
    public function __invoke(Request $serverRequest, Response $response, callable $next);
}