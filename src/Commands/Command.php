<?php

namespace MTNewton\Elixir\Commands;

use Discord\Parts\Channel\Message;
use MTNewton\Elixir\Helpers\Commands;
use MTNewton\Elixir\Helpers\Log;

abstract class Command
{
    protected $alias;
    
    protected $message;

    protected $parent;
    
    public function __construct(string $alias, Message $message, ?Command $parent = null)
    {
        $this->alias = $alias;
        $this->message = $message;
        $this->parent = $parent;
    }
    
    abstract public static function getAliases();

    public static function matchesAlias(string $alias)
    {
        Log::debug('Aliases: ' . json_encode(static::getAliases()));
        foreach (static::getAliases() as $a) {
            if ($a == $alias) {
                return true;
            }
        }
        return false;
    }
    
    public static function getSubCommands() 
    { 
        return [];
    }

    abstract public static function getDescription();

    abstract public function execute();
    
    protected function getContentWithoutCommands()
    {
        $toTrim = [$this->alias];
        $parent = $this->parent;
        while ($parent) {
            $toTrim[] = $parent->alias;
            $parent = $parent->parent;
        }
        $toTrim[] = Commands::getGuildPrefix($this->message->channel->guild);
        $toTrim = array_reverse($toTrim);
        $content = $this->message->content;
        foreach($toTrim as $trim) {
            $content = trim(substr($content, strlen($trim)), ' ');
        }
        return $content;
    }
}
