<?php
namespace Infrastructure\Persistence;

class EntityFactory
{
    /**
     * @param $entity
     * @param array $data
     *
     * @return AbstractEntity
     */
    public static function make($entity, array $data)
    {
        /** @var $entity Entity */
        $blueprint = $entity::getBlueprint();

        $args = [];

        foreach ($blueprint as $key => $pos) {
            $args[$pos] = $data[$key];
        }

        $instance = new $entity(...$args);

        return $instance;
    }
}