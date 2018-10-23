<?php

namespace DivineOmega\CamelCaser;

use DivineOmega\CamelCaser\Alias\Finder\AliasFinder;
use DivineOmega\CamelCaser\Alias\Renderer\AliasRenderer;
use DivineOmega\CamelCaser\Formatter\CamelCaseFormatter;
use DivineOmega\CamelCaser\Formatter\FunctionFormatter;
use DivineOmega\CamelCaser\Formatter\NamespacePrefixFormatter;
use DivineOmega\CamelCaser\Hasher\Md5FunctionHasher;
use ReflectionFunction;
use RuntimeException;
use SplFileObject;
use Throwable;

const INCLUDE_DISABLED = false;
const EXCLUDE_DISABLED = true;

$internalFunctions = array_map(
    function (string $function) : ReflectionFunction {
        return new ReflectionFunction($function);
    },
    get_defined_functions(EXCLUDE_DISABLED)['internal'] ?? []
);

$hasher = new Md5FunctionHasher();
$storage = sprintf(
    __DIR__.'/aliases.%s.php',
    $hasher(...$internalFunctions)
);

if (!file_exists($storage)) {
    $finder = new AliasFinder(
        new NamespacePrefixFormatter(
            new FunctionFormatter()
        ),
        new NamespacePrefixFormatter(
            new CamelCaseFormatter()
        )
    );

    $aliases = $finder(...$internalFunctions);
    $renderer = new AliasRenderer();

    try {
        $render = $renderer(...$aliases);
    } catch (Throwable $exception) {
        $render = null;
    }

    if (is_string($render)) {
        $file = new SplFileObject($storage, 'w+');
        $file->fwrite($render);
    }
}

try {
    require_once $storage;
} catch (Throwable $exception) {
    unlink($storage);

    throw new RuntimeException(
        'Failed to register aliases for internal functions!',
        0,
        $exception
    );
}
