<?php

namespace Linio\Component\Input\Constraint;

class Email extends Constraint
{
    public function __construct($errorMessage = null)
    {
        $this->setErrorMessage($errorMessage ? $errorMessage : 'Invalid email format');
    }

    public function validate($content)
    {
        return (bool) filter_var($content, FILTER_VALIDATE_EMAIL);
    }
}
