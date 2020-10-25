<?php

namespace MTNewton\Elixir\Helpers;

use Throwable;

class Log
{
    public static function info($message) 
    {
        static::log('INFO', is_scalar($message) ? $message : json_encode($message));
    }

    public static function exception(Throwable $t) 
    {        
        static::log('EXCEPTION', json_encode([
            'message' => $t->getMessage(),
            'file' => $t->getFile(),
            'line' => $t->getLine(),
            'trace' => $t->getTrace(),
        ]));
    }

    public static function debug($message)
    {
        if (Env::get('log.debug')){
            static::log('DEBUG', is_scalar($message) ? $message : json_encode($message));
        }
    }

    protected static function log(string $type, string $message)
    {
        echo '[' . static::timestamp() . "] Elixir.{$type}: {$message}" . PHP_EOL;

    }

    protected static function timestamp()
    {
        return date('Y-m-d\TH:i:s.uP');
    }
}