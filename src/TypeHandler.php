<?php

namespace Linio\Component\Input;

use Linio\Component\Input\Instantiator\InstantiatorInterface;
use Linio\Component\Input\Instantiator\SetInstantiator;
use Linio\Component\Input\Node\BaseNode;
use Linio\Component\Input\Node\BoolNode;
use Linio\Component\Input\Node\CollectionNode;
use Linio\Component\Input\Node\DateTimeNode;
use Linio\Component\Input\Node\FloatNode;
use Linio\Component\Input\Node\IntNode;
use Linio\Component\Input\Node\NumericNode;
use Linio\Component\Input\Node\ObjectNode;
use Linio\Component\Input\Node\ScalarCollectionNode;
use Linio\Component\Input\Node\StringNode;

class TypeHandler
{
    /**
     * @var array
     */
    protected $types;

    /**
     * @var InstantiatorInterface
     */
    protected $defaultInstantiator;

    public function __construct()
    {
        $this->types = [
            'bool' => BoolNode::class,
            'int' => IntNode::class,
            'float' => FloatNode::class,
            'double' => FloatNode::class,
            'numeric' => NumericNode::class,
            'string' => StringNode::class,
            'array' => BaseNode::class,
            'object' => ObjectNode::class,
            'datetime' => DateTimeNode::class,
        ];

        $this->defaultInstantiator = new SetInstantiator();
    }

    public function addType($name, $class)
    {
        $this->types[$name] = $class;
    }

    public function getType($name)
    {
        if (isset($this->types[$name])) {
            $type = new $this->types[$name]();
            $type->setTypeHandler($this);

            return $type;
        }

        if ($this->isScalarCollectionType($name)) {
            $type = new ScalarCollectionNode();
            $type->setType($this->getCollectionType($name));
            $type->setTypeHandler($this);

            return $type;
        }

        if ($this->isClassType($name)) {
            $type = new ObjectNode();
            $type->setType($name);
            $type->setTypeHandler($this);
            $type->setInstantiator($this->defaultInstantiator);

            return $type;
        }

        if ($this->isCollectionType($name)) {
            $type = new CollectionNode();
            $type->setType($this->getCollectionType($name));
            $type->setTypeHandler($this);
            $type->setInstantiator($this->defaultInstantiator);

            return $type;
        }

        throw new \InvalidArgumentException('Unknown type name: ' . $name);
    }

    protected function isClassType($type)
    {
        return (class_exists($type) || interface_exists($type)) && $type != 'datetime';
    }

    protected function isCollectionType($type)
    {
        $collectionType = $this->getCollectionType($type);

        if (!class_exists($collectionType)) {
            return false;
        }

        return true;
    }

    protected function isScalarCollectionType($type)
    {
        $collectionType = $this->getCollectionType($type);

        if (!function_exists('is_' . $collectionType)) {
            return false;
        }

        return true;
    }

    protected function getCollectionType($type)
    {
        $pos = strrpos($type, '[]');

        if ($pos === false) {
            return $type;
        }

        return substr($type, 0, $pos);
    }
}
