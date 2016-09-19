<?php

namespace Linio\Component\Input\Constraint;

class NotNull extends Constraint
{
    public function __construct($errorMessage = null)
    {
        $this->setErrorMessage($errorMessage ? $errorMessage : 'Unexpected empty content');
    }

    public function validate($content)
    {
        if ($content) {
            $content = trim($content);
        }

        return $content !== null && $content !== '';
    }
}
