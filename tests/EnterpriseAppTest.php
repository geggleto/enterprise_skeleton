<?php
namespace Tests\Infrastructure;


use Infrastructure\EnterpriseApp;

class EnterpriseAppTest extends Base
{
    public function testConstruction() {
        $app = new EnterpriseApp(__DIR__."/testConfig.php");

        $this->assertEquals('b', $app->getContainer()->get('a'));
    }
}