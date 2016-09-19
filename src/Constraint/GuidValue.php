<?php

namespace Linio\Component\Input\Constraint;

class GuidValue extends Constraint
{
    public function __construct($errorMessage = null)
    {
        $this->setErrorMessage($errorMessage ? $errorMessage : 'Invalid GUID format');
    }

    public function validate($content)
    {
        if (!is_string($content) || strlen($content) != 36) {
            return false;
        }

        return (bool) preg_match('/^[0-9a-fA-F]{8}\-([0-9a-fA-F]{4}\-){3}[0-9a-fA-F]{12}$/', $content);
    }
}
