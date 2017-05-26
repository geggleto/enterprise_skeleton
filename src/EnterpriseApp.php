<?php


namespace Infrastructure;

use DI\Bridge\Slim\App;
use DI\ContainerBuilder;

/**
 * Class EnterpriseApp
 * @package Infrastructure
 *
 *
 */
class EnterpriseApp extends App
{
    protected $pathToDIConfig;

    public function __construct($diConfigFile = '')
    {
        if (file_exists($diConfigFile)) {
            $this->pathToDIConfig = $diConfigFile;
        }

        parent::__construct();
     }

    protected function configureContainer(ContainerBuilder $builder)
    {
        $settings = include $this->pathToDIConfig;
        $builder->addDefinitions($settings);
    }
}