<?php
namespace Tests\Infrastructure;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

abstract class Base extends \PHPUnit_Framework_TestCase
{
    use MockeryPHPUnitIntegration;
}