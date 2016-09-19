<?php

namespace Linio\Component\Input\Node;

class ObjectNode extends BaseNode
{
    public function getValue($field, $value)
    {
        $this->checkConstraints($field, $value);

        return $this->instantiator->instantiate($this->type, $value);
    }
}
