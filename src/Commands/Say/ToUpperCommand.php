<?php

namespace MTNewton\Elixir\Commands\Say;

use MTNewton\Elixir\Commands\Command;

class ToUpperCommand extends Command  
{
    
    public static function getAliases()
    {
        return [
            'toupper'
        ];
    }

    public static function getDescription()
    {
        return 'ECHO';
    }

    public function execute()
    {
        return strtoupper($this->getContentWithoutCommands());
    }
}
