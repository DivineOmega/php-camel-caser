<?php

require_once __DIR__.'/vendor/autoload.php';

$functions = get_defined_functions();
$internalFunctions = $functions['internal'];

foreach($internalFunctions as $funcName) {

    $newFuncNames = [];
    $newFuncNames[] = camel_case($funcName);

    foreach($newFuncNames as $newFuncName) {

        if (!$newFuncName) {
            continue;
        }

        if (!function_exists($newFuncName)) {

            eval('
                
                function ' . $newFuncName . '() {
                    $args = func_get_args();
                    return call_user_func_array(\'' . $funcName . '\', $args);
                };
    
            ');

        }
    }
}

echo strReplace('bar', 'baz', 'foobar').PHP_EOL;
