<?php

namespace Linio\Component\Input\Instantiator;

class ConstructInstantiator implements InstantiatorInterface
{
    public function instantiate($class, array $data)
    {
        return new $class(...$data);
    }
}
