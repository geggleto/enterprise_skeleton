<?php


namespace Infrastructure\Persistence;


use Throwable;

class ValidationException extends \Exception
{
    protected $errors;

    public function __construct(array $errorList = [], $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->errors = $errorList;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}