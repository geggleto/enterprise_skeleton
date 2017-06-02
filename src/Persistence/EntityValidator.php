<?php


namespace Infrastructure\Persistence;


interface EntityValidator
{
    /**
     * @param array $data
     * @throws ValidationException
     * @return bool
     */
    public function validate(array $data);
}