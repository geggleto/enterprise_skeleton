<?php


namespace Tests\Infrastructure\Http\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Infrastructure\Events\Adapters\CustomEventDispatcher;
use Infrastructure\Http\Controller\RestController;
use Infrastructure\Persistence\RepositoryFactory;
use Mockery;
use Psr\Container\ContainerInterface;
use Slim\Container;
use Slim\Http\Response;
use Tests\Infrastructure\Base;
use Tests\Infrastructure\Persistence\UserEntity;
use Tests\Infrastructure\Persistence\UserRepository;

class RestControllerTest extends Base
{

    public function testCreate()
    {
        /** @var $entityManager EntityManagerInterface */
        $entityManager = Mockery::mock(EntityManagerInterface::class);

        $entityManager->shouldReceive('persist')
            ->once()
            ->withAnyArgs()
            ->andReturn()
            ->mock();

        $entityManager->shouldReceive('flush')
            ->once()
            ->withNoArgs()
            ->andThrow(ORMException::class, 'Error')
            ->mock();


        $container = new Container();

        $dispatcher = new CustomEventDispatcher($container);

        $container[UserRepository::class] = function (ContainerInterface $container) use($entityManager, $dispatcher)
        {
            return new UserRepository($entityManager, $dispatcher);
        };

        $controller = new RestController(
            UserEntity::class,
            new RepositoryFactory(
                $container,
                [
                    UserEntity::class => UserRepository::class
                ]
            )
        );

        $value = bin2hex(random_bytes(8));

        $request = $this->requestFactory();
        $request = $request->withParsedBody([
            'string' => $value
        ]);

        $response = $controller->createObject($request, new Response());
        $response->getBody()->rewind();
        $body = $response->getBody()->__toString();

        $this->assertContains($value, $body);
    }
}