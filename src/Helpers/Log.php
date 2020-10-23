<?php

namespace MTNewton\Elixir\Helpers;

use Exception;

class Log
{
    public static function info($message) 
    {
        static::log('INFO', is_scalar($message) ? $message : json_encode($message));
    }

    public static function exception(Exception $e) 
    {        
        static::log('EXCEPTION', json_encode([
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTrace(),
        ]));
    }

    public static function debug($message)
    {
        if (Config::get('log.debug')){
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