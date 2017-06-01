<?php


namespace Infrastructure\Persistence;


use Infrastructure\Exceptions\InvalidEntityException;

interface Entity
{
    /**
     * @param array $data
     * @throws InvalidEntityException
     * @return static
     */
    static function fromArray(array $data);
}