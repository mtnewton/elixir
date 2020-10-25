<?php

namespace MTNewton\Elixir\Commands;

class PingCommand extends Command
{
    
    public static function getAliases()
    {
        return [
            'ping'
        ];
    }

    public static function getDescription()
    {
        return 'pong!';
    }

    public function execute() 
    {
        return 'pong!';
    }
}
