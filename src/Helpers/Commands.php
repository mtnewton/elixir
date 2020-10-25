<?php

namespace MTNewton\Elixir\Helpers;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\Parts\Guild\Guild;
use Throwable;

class Commands
{
    public static function register(Discord $discord)
    {
        $commands = require __DIR__ . '/../Config/commands.php';

        $discord->on('message', function (Message $message) use ($discord, $commands){
            Log::debug("Recieved a message from {$message->author->username}: {$message->content}");
            if ($message->author->id == $discord->id) {
                return;
            }

            $prefix = self::getGuildPrefix($message->channel->guild); // todo: check for prefix set by server
            
            Log::debug("Prefix: {$prefix}");
            
            if (!str_starts_with($message->content, $prefix)) {
                return;
            }
            
            $commandToRun = null;
            $content = trim(substr($message->content, strlen($prefix)), ' ');
            $alias = explode(' ', $content)[0];
            
            Log::debug("Alias: {$alias}");

            while(!empty($commands)) {
                foreach ($commands as $command) {
                    Log::debug('Checking command: ' . $command . " {$alias}");
                    if ($command::matchesAlias($alias, $content)) {
                        Log::debug('Matches command: ' . $command);
                        $commandToRun = new $command($alias, $message, $commandToRun);
                        $content = trim(substr($content, strlen($alias)), ' ');
                        $alias = explode(' ', $content)[0];
                        $commands = $commandToRun::getSubCommands();
                        continue 2;
                    }
                }
                break;
            }

            if ($commandToRun) {
                try {
                    $response = $commandToRun->execute();
                    $message->channel->sendMessage($response);
                } catch (Throwable $t) {
                    Log::exception($t);
                }
                return;
            }

            Log::debug('No matching command found');
        });
    }

    public static function getGuildPrefix(Guild $guild) 
    {
        return Env::get('discord.prefix');
    }
}
