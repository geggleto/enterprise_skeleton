<?php


namespace Infrastructure\Persistence;


interface Entity
{
    /**
     * @return array
     */
    static function getBlueprint();

    /**
     * @return array
     */
    static function getRequiredFields();
}