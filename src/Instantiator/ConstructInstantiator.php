<?php

declare(strict_types=1);

namespace Linio\Component\Input\Instantiator;

class ConstructInstantiator implements InstantiatorInterface
{
    public function instantiate(string $class, ?array $data)
    {
        if ($data === null) {
            return null;
        }

        return new $class(...array_values($data));
    }
}
