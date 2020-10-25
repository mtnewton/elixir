<?php

namespace MTNewton\Elixir\Commands;

use Carbon\Carbon;
use Exception;

class TimeCommand extends Command
{
    public static function getAliases() 
    {
        return [
            'time',
            'date',
        ];
    }

    public static function getDescription()
    {
        return 'Returns the current time, optionally pass a timezone';
    }

    public function execute()    
    {
        $timezone = explode(' ', $this->getContentWithoutCommands())[0];
        $carbon = Carbon::now();
        if ($timezone) {
            try{
                $carbon->setTimezone($timezone);
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
        return $carbon->isoFormat('LLLL z');
    }
}
