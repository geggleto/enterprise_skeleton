<?php
namespace Infrastructure\Persistence;

class EntityFactory
{
    /**
     * @param $entity
     * @param $data
     *
     * @return AbstractEntity
     */
    public static function make($entity, array $data)
    {
        $blueprint = $entity::blueprint;
        $args = [];
        foreach ($blueprint as $key => $pos) {
            $args[0] = $data[$key];
        }
        $entity = new $entity(...$args);

        return $entity;
    }
}