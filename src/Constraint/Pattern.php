<?php

namespace Linio\Component\Input\Constraint;

class Pattern extends Constraint
{
    /**
     * @var string
     */
    protected $pattern;

    public function __construct($pattern, $errorMessage = null)
    {
        $this->pattern = $pattern;

        $this->setErrorMessage($errorMessage ? $errorMessage : 'Required pattern does not match');
    }

    public function validate($content)
    {
        if (!$content) {
            return false;
        }

        return (bool) preg_match($this->pattern, $content);
    }
}
