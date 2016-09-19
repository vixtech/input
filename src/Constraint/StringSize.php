<?php

namespace Linio\Component\Input\Constraint;

class StringSize extends Constraint
{
    /**
     * @var int
     */
    protected $minSize;

    /**
     * @var int
     */
    protected $maxSize;

    public function __construct($minSize, $maxSize = PHP_INT_MAX, $errorMessage = null)
    {
        $this->minSize = $minSize;
        $this->maxSize = $maxSize;

        $errorMessage = $errorMessage ?
            $errorMessage :
            sprintf('Content out of min/max limit sizes [%s, %s]', $this->minSize, $this->maxSize);

        $this->setErrorMessage($errorMessage);
    }

    public function validate($content)
    {
        if ($content === null) {
            return false;
        }

        $size = strlen($content);

        return $size >= $this->minSize && $size <= $this->maxSize;
    }
}
