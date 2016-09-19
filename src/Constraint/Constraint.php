<?php

namespace Linio\Component\Input\Constraint;

abstract class Constraint implements ConstraintInterface
{
    /**
     * @var string
     */
    protected $errorMessage;

    public function getErrorMessage($field)
    {
        return sprintf('[%s] %s', $field, $this->errorMessage);
    }

    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }
}
