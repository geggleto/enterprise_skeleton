<?php
namespace Infrastructure\Http\Middleware;


use Infrastructure\Events\EventDispatcher;
use Slim\Http\Request;
use Slim\Http\Response;


use Monolog\Logger;

class ApiLogMiddleware
{
    /** @var EventDispatcher  */
    private $dispatcher;

    /** @var Logger  */
    private $logger;

    public function __construct(EventDispatcher $dispatcher, Logger $logger)
    {
        $this->dispatcher = $dispatcher;
        $this->logger = $logger;
    }

    public function __invoke(Request $request, Response $response, $next)
    {
        /** @var $response Response */
        $response = $next($request, $response);

        //TODO do something with errors?

        return $response;
    }
}