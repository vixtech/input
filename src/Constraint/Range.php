<?php

namespace Linio\Component\Input\Constraint;

class Range extends Constraint
{
    /**
     * @var int
     */
    protected $min;

    /**
     * @var int
     */
    protected $max;

    public function __construct($min, $max = PHP_INT_MAX, $errorMessage = null)
    {
        $this->min = $min;
        $this->max = $max;

        $errorMessage = $errorMessage ?
            $errorMessage :
            sprintf('Value is not between %d and %d', $this->min, $this->max);

        $this->setErrorMessage($errorMessage);
    }

    public function validate($content)
    {
        if ($content === null) {
            return false;
        }

        return $content >= $this->min && $content <= $this->max;
    }
}
