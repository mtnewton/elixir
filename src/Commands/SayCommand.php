<?php

namespace MTNewton\Elixir\Commands;

use MTNewton\Elixir\Commands\Say\ToUpperCommand;

class SayCommand extends Command
{
    
    public static function getCommandName()
    {
        return 'say';
    }

    public static function getDescription()
    {
        return 'echo';
    }

    public static function getAliases() 
    {
        return [
            'echo',
        ];
    }

    public static function getSubCommands() 
    {
        return [
            ToUpperCommand::class
        ];
    }

    public static function execute($message, $params)
    {
        return implode(' ', $params);
    }
}
