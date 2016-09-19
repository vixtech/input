<?php

namespace Linio\Component\Input\Constraint;

class Type extends Constraint
{
    /**
     * @var string
     */
    protected $type;

    public function __construct($type, $errorMessage = null)
    {
        $this->type = $type;

        $this->setErrorMessage($errorMessage ? $errorMessage : 'Value does not match type: ' . $this->type);
    }

    public function validate($content)
    {
        return call_user_func('is_' . $this->type, $content);
    }
}
