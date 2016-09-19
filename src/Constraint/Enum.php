<?php

namespace Linio\Component\Input\Constraint;

class Enum extends Constraint
{
    /**
     * @var array
     */
    protected $enumValues = [];

    public function __construct(array $enumValues, $errorMessage = null)
    {
        $this->enumValues = $enumValues;

        $errorMessage = $errorMessage ?
            $errorMessage :
            'Invalid option for enum. Allowed options are: ' . implode(', ', $this->enumValues);

        $this->setErrorMessage($errorMessage);
    }

    public function validate($content)
    {
        return in_array($content, $this->enumValues);
    }
}
