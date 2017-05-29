<?php
namespace Infrastructure\Persistence;

class EntityFactory
{
    /**
     * @param Entity $entity
     * @param array $data
     *
     * @return AbstractEntity
     */
    public static function make($entity, array $data)
    {

        $blueprint = $entity::getBlueprint();

        $args = [];

        foreach ($blueprint as $key => $pos) {
            $args[0] = $data[$key];
        }

        $entity = new $entity(...$args);

        return $entity;
    }
}