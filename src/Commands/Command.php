<?php

namespace MTNewton\Elixir\Commands;

abstract class Command
{
    abstract public static function getCommandName();

    abstract public static function getDescription();

    public static function getSubCommands() 
    { 
        return [];
    }

    public static function getAliases()
    {
        return [];
    }

    abstract public static function execute($message, $params);
}
