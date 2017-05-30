<?php


namespace Infrastructure\Persistence;


interface Entity
{
    /**
     * @param array $data
     * @return static
     */
    static function fromArray(array $data);

    /**
     * @return array
     */
    static function getBlueprint();

    /**
     * @return array
     */
    static function getRequiredFields();
}