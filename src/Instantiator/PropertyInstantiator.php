<?php

namespace Linio\Component\Input\Instantiator;

use Doctrine\Common\Inflector\Inflector;

class PropertyInstantiator implements InstantiatorInterface
{
    public function instantiate($class, array $data)
    {
        $object = new $class();

        foreach ($data as $key => $value) {
            $property = Inflector::camelize($key);
            $object->$property = $value;
        }

        return $object;
    }
}
