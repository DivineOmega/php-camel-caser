<?php

namespace DivineOmega\CamelCaser\Alias\Finder;

use DivineOmega\CamelCaser\Alias\Alias;
use DivineOmega\CamelCaser\Alias\AliasIterator;
use DivineOmega\CamelCaser\Alias\AliasIteratorInterface;
use DivineOmega\CamelCaser\Formatter\FunctionFormatterInterface;
use ReflectionFunctionAbstract;

class AliasFinder implements AliasFinderInterface
{
    /** @var FunctionFormatterInterface */
    private $orinalFormatter;

    /** @var FunctionFormatterInterface */
    private $aliasFormatter;

    /**
     * Constructor.
     *
     * @param FunctionFormatterInterface $orinalFormatter
     * @param FunctionFormatterInterface $aliasFormatter
     */
    public function __construct(
        FunctionFormatterInterface $orinalFormatter,
        FunctionFormatterInterface $aliasFormatter
    ) {
        $this->orinalFormatter = $orinalFormatter;
        $this->aliasFormatter  = $aliasFormatter;
    }

    /**
     * Find aliases for the given list of functions.
     *
     * @param ReflectionFunctionAbstract ...$functions
     *
     * @return AliasIteratorInterface
     */
    public function __invoke(
        ReflectionFunctionAbstract ...$functions
    ): AliasIteratorInterface {
        $aliases = [];

        foreach ($functions as $function) {
            $original = $this->orinalFormatter->__invoke($function);
            $alias    = $this->aliasFormatter->__invoke($function);

            if ($alias === $original
                || empty($alias)
                || !preg_match('/.*?([^\\\\]+)$/', $alias)
                || !function_exists($original)
                || function_exists($alias)
            ) {
                continue;
            }

            $aliases[] = new Alias($original, $alias, $function);
        }

        return new AliasIterator(...$aliases);
    }
}
