<?php


namespace Infrastructure\Persistence;


use Slim\Http\Request;
use Slim\Http\Response;
use Valitron\Validator;

class SimpleEntityValidator
{
    protected $entityClass;

    public function __construct($entityClass = '')
    {
        $this->entityClass = $entityClass;
    }

    public function __invoke(Request $request, Response $response, $next)
    {
        $entity = $this->entityClass;

        $valitron = new Validator($request->getParsedBody());
        $valitron->rule('required', array_keys($entity::bootstrap));

        if ($valitron->validate()) {
            return $next($request, $response);
        } else {
            return $response->withJson($valitron->errors(), 400);
        }
    }
}