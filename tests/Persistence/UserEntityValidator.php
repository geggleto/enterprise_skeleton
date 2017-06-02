<?php


namespace Tests\Infrastructure\Persistence;


use Infrastructure\Persistence\EntityValidator;
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
     * @return array|bool
     */
    public function validate(array $data)
    {
        $this->valitron->withData($data);

        if ($this->valitron->validate())
            return true;
        else
            return $this->valitron->errors();
    }

}