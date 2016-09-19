<?php

namespace Linio\Component\Input\Exception;

class RequiredFieldException extends \RuntimeException
{
    /**
     * @var string
     */
    protected $field;

    public function __construct($field)
    {
        $this->field = $field;
    }

    public function getField()
    {
        return $this->field;
    }
}
