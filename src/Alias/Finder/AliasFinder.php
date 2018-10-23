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
    private $originalFormatter;

    /** @var FunctionFormatterInterface */
    private $aliasFormatter;

    /**
     * Constructor.
     *
     * @param FunctionFormatterInterface $originalFormatter
     * @param FunctionFormatterInterface $aliasFormatter
     */
    public function __construct(
        FunctionFormatterInterface $originalFormatter,
        FunctionFormatterInterface $aliasFormatter
    ) {
        $this->originalFormatter = $originalFormatter;
        $this->aliasFormatter = $aliasFormatter;
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
        return new AliasIterator(
            ...array_values(
                array_reduce(
                    $functions,
                    function (
                        array $carry,
                        ReflectionFunctionAbstract $function
                    ): array {
                        $original = $this->originalFormatter->__invoke($function);
                        $alias = $this->aliasFormatter->__invoke($function);

                        if ($alias !== $original
                            && preg_match('/.*?([^\\\\]+)$/', $alias)
                            && function_exists($original)
                            && !function_exists($alias)
                        ) {
                            $carry[$alias] = new Alias(
                                $original,
                                $alias,
                                $function
                            );
                        }

                        return $carry;
                    },
                    []
                )
            )
        );
    }
}
