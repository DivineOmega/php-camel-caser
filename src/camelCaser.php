<?php

if (! function_exists('camelCaser')) {

    function camelCaser()
    {

        $functions = get_defined_functions(true);
        $filePath = __DIR__ . DIRECTORY_SEPARATOR . 'camelCaserFunctions.php';
        $fileRes = fopen($filePath, 'w');
        $defined = [];
        $code = null;

        foreach ($functions['internal'] as $funcName)
        {
            $newFuncName = str_replace('_', null, $funcName);

            if (! function_exists($newFuncName) && strlen($funcName) > 3 && ! isset($defined[$newFuncName])) {

                $defined[$newFuncName] = true;

                $code .= "
                    function {$newFuncName}()
                    {
                        return {$funcName}(... func_get_args());
                    }
                ";
            }
        }

        if ($code !== null) {

            $namespace = getenv('CAMEL_CASER_NAMESPACE');

            if ($namespace) {
                $namespace = "namespace {$namespace}; ";
            }

            fwrite($fileRes, '<?php '. $namespace . $code . PHP_EOL);
            require($filePath);
        }

        fclose($fileRes);

    }

    camelCaser();
}
