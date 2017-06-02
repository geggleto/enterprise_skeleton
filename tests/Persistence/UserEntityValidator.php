<?php


namespace Tests\Infrastructure\Persistence;


use Infrastructure\Persistence\EntityValidator;
use Infrastructure\Persistence\ValidationException;
use Valitron\Validator;

class UserEntityValidator implements EntityValidator
{
    protected $valitron;

    /**
     * UserEntityValidator constructor.
     */
    public function __construct()
    {
        $this->valitron = new Validator();

        $this->valitron->rule('required', ['string']);
    }

    /**
     * @param array $data
     * @return bool
     * @throws ValidationException
     */
    public function validate(array $data)
    {
        $this->valitron->withData($data);

        if (!$this->valitron->validate()) {
            throw new ValidationException($this->valitron->errors());
        }

        return true;
    }

}