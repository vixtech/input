<?php

namespace Linio\Component\Input\Node;

class ObjectNode extends BaseNode
{
    public function getValue($field, $value)
    {
        $this->checkConstraints($field, $value);

        if ($this->transformer) {
            return $this->transformer->transform($value);
        }

        return $this->instantiator->instantiate($this->type, $value);
    }
}
