<?php

namespace Linio\Component\Input\Constraint;

class DateRange extends Constraint
{
    /**
     * @var string
     */
    protected $min;

    /**
     * @var string
     */
    protected $max;

    public function __construct($min, $max, $errorMessage = null)
    {
        $this->min = $min;
        $this->max = $max;

        $errorMessage = $errorMessage ?
            $errorMessage :
            sprintf('Date is not between "%s" and "%s"', $this->min, $this->max);

        $this->setErrorMessage($errorMessage);
    }

    public function validate($content)
    {
        $date = new \DateTime($content);

        return $date >= new \DateTime($this->min) && $date <= new \DateTime($this->max);
    }
}
