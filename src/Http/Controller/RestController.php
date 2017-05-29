<?php
namespace Infrastructure\Http\Controller;


use Infrastructure\Persistence\AbstractEntity;
use Infrastructure\Persistence\AbstractRepository;
use Infrastructure\Persistence\EntityFactory;
use Infrastructure\ValueObject\Identity\Uuid;
use Slim\Http\Request;
use Slim\Http\Response;

class RestController
{
    /** @var AbstractRepository  */
    protected $repository;

    /** @var string */
    protected $entityName;

    /**
     * RestController constructor.
     * @param string $entityName
     * @param AbstractRepository $repository
     */
    public function __construct($entityName = '', AbstractRepository $repository)
    {
        $this->entityName = $entityName;
        $this->repository = $repository;
    }

    /**
     * @param $uuid
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function getObject($uuid, Request $request, Response $response)
    {
        $entity = $this->repository->find(new Uuid($uuid));

        return $response->withJson($entity->toArray());
    }

    /**
     * @param $uuid
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function putObject($uuid, Request $request, Response $response)
    {
        $entity = $this->repository->find(new Uuid($uuid));
        $entity->update($request->getParsedBody());

        $this->repository->store($entity);

        return $response->withJson($entity->toArray());
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function createObject(Request $request, Response $response)
    {
        $args = $request->getParsedBody();
        $args['uuid'] = new Uuid();

        /** @var $entity AbstractEntity */
        $entity = EntityFactory::make($this->entityName, $args);

        $this->repository->store($entity);

        return $response->withJson($entity->toArray());
    }

    /**
     * @param $uuid
     * @param Response $response
     *
     * @return Response
     */
    public function removeObject($uuid, Response $response)
    {
        $entity = $this->repository->find(new Uuid($uuid));

        $this->repository->remove($entity);

        return $response->withStatus(200);
    }
}