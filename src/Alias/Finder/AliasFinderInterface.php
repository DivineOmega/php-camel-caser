<?php

namespace DivineOmega\CamelCaser\Alias\Finder;

use DivineOmega\CamelCaser\Alias\AliasIteratorInterface;
use ReflectionFunctionAbstract;

interface AliasFinderInterface
{
    /**
     * Find aliases for the given list of functions.
     *
     * @param ReflectionFunctionAbstract ...$functions
     *
     * @return AliasIteratorInterface
     */
    public function __invoke(
        ReflectionFunctionAbstract ...$functions
    ): AliasIteratorInterface;
}
