<?php


namespace Infrastructure\Persistence;


interface EntityBuilder
{
    /**
     * @return static
     */
    public function getEntity();
}