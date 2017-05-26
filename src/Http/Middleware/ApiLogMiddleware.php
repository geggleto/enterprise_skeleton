<?php
namespace Infrastructure\Http\Middleware;


use Infrastructure\Events\EventDispatcher;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;


use Monolog\Logger;

class ApiLogMiddleware
{
    /** @var LoggerInterface  */
    private $logger;

    /**
     * ApiLogMiddleware constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $next
     * @return Response
     */
    public function __invoke(Request $request, Response $response, $next)
    {
        /** @var $response Response */
        $response = $next($request, $response);

        if ($response->getStatusCode() >= 500) {
            $this->logger->emergency('Request returned Server Error', [$request]);
        }

        return $response;
    }
}