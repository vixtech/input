<?php

namespace Linio\Component\Input;

use Linio\Component\Input\Exception\RequiredFieldException;
use Linio\Component\Input\Node\BaseNode;

abstract class InputHandler
{
    /**
     * @var BaseNode
     */
    protected $root;

    /**
     * @var TypeHandler
     */
    protected $typeHandler;

    /**
     * @var array
     */
    protected $output = [];

    /**
     * @var array
     */
    protected $errors = [];

    public function __construct(TypeHandler $typeHandler = null)
    {
        $this->root = new BaseNode();
        $this->typeHandler = $typeHandler ? $typeHandler : new TypeHandler();
        $this->root->setTypeHandler($this->typeHandler);
    }

    public function add($key, $type, array $options = [])
    {
        return $this->root->add($key, $type, $options);
    }

    public function remove($key)
    {
        $this->root->remove($key);
    }

    public function getRoot()
    {
        return $this->root;
    }

    public function setRootType($type)
    {
        $this->root = $this->typeHandler->getType($type);
    }

    public function bind(array $input)
    {
        $this->define();

        try {
            $this->output = $this->root->getValue('root', $this->root->walk($input));
        } catch (RequiredFieldException $exception) {
            $this->errors[] = 'Missing required field: ' . $exception->getField();
        } catch (\RuntimeException $exception) {
            $this->errors[] = $exception->getMessage();
        }
    }

    public function getData($index = null)
    {
        if (!$this->isValid()) {
            throw new \RuntimeException($this->getErrorsAsString());
        }

        if ($index) {
            return $this->output[$index];
        }

        return $this->output;
    }

    public function hasData($index)
    {
        return isset($this->output[$index]);
    }

    public function isValid()
    {
        return empty($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getErrorsAsString()
    {
        return implode(', ', $this->errors);
    }

    abstract public function define();
}
