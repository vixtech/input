<?php

namespace Linio\Component\Input\Node;

use Linio\Component\Input\Constraint\Type;

class FloatNode extends BaseNode
{
    public function __construct()
    {
        $this->addConstraint(new Type('float'));
    }
}
