<?php

use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

if (! function_exists('dump')) {
    /**
     * Dump a value with elegance.
     *
     * @param  mixed  $value
     * @return void
     */
    function dump(...$args)
    {
        foreach ($args as $arg) {
            if (class_exists(CliDumper::class)) {
                $dumper = 'cli' === PHP_SAPI ? new CliDumper() : new HtmlDumper();
                $dumper->dump((new VarCloner())->cloneVar($arg));
            } else {
                var_dump($arg);
            }
        }

        die(1);
    }
}

if (! function_exists('dd')) {
    /**
     * Dump the passed variables and end the script.
     *
     * @param  mixed
     * @return void
     */
    function dd(...$args)
    {
        foreach ($args as $arg) {
            (new Dumper())->dump($arg);
        }

        die(1);
    }
}
