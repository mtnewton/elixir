<?php

namespace MTNewton\Elixir\Commands;

class PingCommand extends Command
{
    
    public static function getCommandName()
    {
        return 'ping';
    }

    public static function getDescription()
    {
        return 'pong!';
    }

    public static function execute($message, $params)
    {
        return 'pong!';
    }
}
