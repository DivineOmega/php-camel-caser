<?php

namespace DivineOmega\CamelCaser\Alias\Renderer;

use DivineOmega\CamelCaser\Alias\AliasInterface;

interface AliasRendererInterface
{
    /**
     * Render code for the given aliases.
     *
     * @param AliasInterface ...$aliases
     *
     * @return string
     */
    public function __invoke(AliasInterface ...$aliases): string;
}
