<?php

if (! function_exists('camelCaser')) {

    function camelCaser()
    {

        $functions = get_defined_functions(true);
        $tempInclude = tmpfile();
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
            
            $namespace = defined('CAMEL_CASER_NAMESPACE') ? 'namespace ' . CAMEL_CASER_NAMESPACE . '; ' : '';
            fwrite($tempInclude, '<?php '. $namespace . '; '. $code . PHP_EOL);
            require(stream_get_meta_data($tempInclude)['uri']);
        }

        fclose($tempInclude);

    }

    camelCaser();
}
