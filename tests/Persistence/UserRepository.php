<?php


namespace Tests\Infrastructure\Persistence;


use Infrastructure\Persistence\AbstractEntity;
use Infrastructure\Persistence\AbstractRepository;
use Infrastructure\ValueObject\Identity\Uuid;

class UserRepository extends AbstractRepository
{
    /**
     * @param Uuid $uuid
     * @return AbstractEntity
     */
    public function find(Uuid $uuid)
    {
        /** @var $entity UserEntity */
        $entity = $this->entityManager->find(UserEntity::class, $uuid->toString());

        return $entity;
    }
}