<?php

namespace MTNewton\Elixir\Commands\Say;

use MTNewton\Elixir\Commands\Command;
use MTNewton\Elixir\Helpers\Log;

class ToUpperCommand extends Command  
{
    
    public static function getCommandName()
    {
        return 'toupper';
    }

    public static function getDescription()
    {
        return 'ECHO';
    }

    public static function execute($message, $params)
    {
        return strtoupper(implode(' ', $params));
    }
}
