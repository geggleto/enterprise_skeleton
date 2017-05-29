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
        $args = [];
        foreach ($data as $value) {
            $args[] = $value;
        }
        $entity = new $entity(...$args);

        return $entity;
    }
}