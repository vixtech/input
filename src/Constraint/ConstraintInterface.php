<?php

namespace Linio\Component\Input\Constraint;

interface ConstraintInterface
{
    public function validate($content);
    public function getErrorMessage($field);
}
