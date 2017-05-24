<?php

use Infrastructure\Messaging\Middleware\CommandQueueMiddleware;
use League\Tactician\CommandBus;
use League\Tactician\Container\ContainerLocator;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;
use Psr\Container\ContainerInterface;

return [
    'businesses.swagger' => __DIR__ . "/../swagger/businesses.yaml",
    'settings.doctrine.xml' => [
        __DIR__ . "/../src/Domain/Identity/Xml",
        __DIR__ . "/../src/Domain/Vehicle/Xml",
        __DIR__ . "/../src/Domain/Business/Xml",
        __DIR__ . "/../src/Domain/Lead/Xml",
        __DIR__ . "/../src/Domain/Publisher/Xml",
        __DIR__ . "/../src/Domain/Report/Xml",
        __DIR__ . "/../src/Domain/Events/Xml",
    ],
    'settings.command_bus.exchange_name' => 'my_exchange',
    'settings.command_bus.dead_letter_exchange_name' => 'my_dlx_exchange',
    'settings.command_bus.command_handler_mappings' => function (ContainerInterface $container) {
        return include __DIR__ . "/command-mapping.php";
    },
    \Infrastructure\Messaging\CommandBus::class => function (ContainerInterface $container) {
        $commandMappings = [];

        foreach ($container->get('settings.command_bus.command_handler_mappings') as $mapping) {
            $commandMappings[$mapping['command']] = $mapping['handler'];
        }

        $containerLocator = new ContainerLocator(
            $container,
            $commandMappings
        );

        $rabbitMQ = $container->get(\Infrastructure\Messaging\Adapters\RabbitMQ::class);

        $commandHandlerMiddleware = new CommandHandlerMiddleware(
            new ClassNameExtractor(),
            $containerLocator,
            new HandleInflector()
        );

        $commandBus = new CommandBus(
            [
                new \League\Tactician\Plugins\LockingMiddleware(),
                new CommandQueueMiddleware($rabbitMQ, $container->get('settings.command_bus.exchange_name')),
                $container->get(\Infrastructure\Messaging\Middleware\EntityManagerMiddleware::class),
                $commandHandlerMiddleware,
            ]
        );

        return new \Infrastructure\Messaging\Adapters\Tactician($commandBus);
    }
];