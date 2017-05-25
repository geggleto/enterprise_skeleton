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
        parent::__construct();

        if (file_exists($diConfigFile)) {
            $this->pathToDIConfig = $diConfigFile;
        }
     }

    protected function configureContainer(ContainerBuilder $builder)
    {
        $builder->addDefinitions($this->pathToDIConfig);
    }
}