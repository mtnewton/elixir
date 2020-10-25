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
        return 'Repeat whatever is said in uppercase';
    }

    public function execute()
    {
        return strtoupper($this->getContentWithoutCommands());
    }
}
