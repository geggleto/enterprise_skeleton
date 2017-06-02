<?php


namespace Infrastructure\Persistence;


interface EntityValidator
{
    /**
     * @param array $data
     * @return array|bool
     */
    public function validate(array $data);
}