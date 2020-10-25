<?php

namespace MTNewton\Elixir\Commands;

use MTNewton\Elixir\Commands\Say\ToUpperCommand;

class SayCommand extends Command
{
    public static function getAliases() 
    {
        return [
            'say',
            'echo',
        ];
    }

    public static function getDescription()
    {
        return 'Repeat whatever is said';
    }

    public static function getSubCommands() 
    {
        return [
            ToUpperCommand::class
        ];
    }

    public function execute()    
    {
        return $this->getContentWithoutCommands();
    }
}
