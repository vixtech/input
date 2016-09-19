<?php

namespace Linio\Component\Input\Instantiator;

interface InstantiatorInterface
{
    public function instantiate($class, array $data);
}
