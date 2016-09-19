<?php

namespace Linio\Component\Input\Constraint;

class Url extends Constraint
{
    public function __construct($errorMessage = null)
    {
        $this->setErrorMessage($errorMessage ? $errorMessage : 'Invalid URL format');
    }

    public function validate($content)
    {
        return (bool) filter_var($content, FILTER_VALIDATE_URL);
    }
}
