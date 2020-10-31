<?php

namespace MTNewton\Elixir\Helpers;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\Parts\Guild\Guild;
use Throwable;

class Commands
{
    private static $commandsFile = __DIR__ . '/../Config/commands.php';

    public static function register(Discord $discord): void
    {

        $discord->on('message', function (Message $message) use ($discord){
            self::logMessage($message);
            self::handle($discord, $message);
        });
    }

    public static function handle(Discord $discord, Message $message): void
    {
        if (self::isMyOwnMessage($message, $discord) || self::isNotMyGuildPrefix($message)) {
            return;
        }
        
        $commandToRun = self::getCommandToRun($message);

        if (!$commandToRun) {
            Log::debug('No matching command found');
            return;
        }
        
        try {
            $response = $commandToRun->execute();
            $message->channel->sendMessage($response);
        } catch (Throwable $t) {
            Log::exception($t);
        }
    }

    public static function getCommandToRun(Message $message): string
    {
        $commandtoRun = '';
        $content = self::getNextContent($message->content, self::$prefix);
        $alias = self::getAliasFromContent($content);

        $commands = self::getCommands();
        while(!empty($commands)) {
            foreach ($commands as $command) {
                Log::debug("Checking command: {$command} against {$alias}");
                if ($command::matchesAlias($alias)) {
                    Log::debug("Matched command: {$command}");
                    $commandToRun = new $command($alias, $message, $commandToRun);
                    $content = self::getNextContent($content, $alias);
                    $alias = self::getAliasFromContent($content);
                    $commands = $commandToRun::getSubCommands();
                    continue 2;
                }
            }
            break;
        }

        return $commandToRun;
    }

    public static function logMessage(Message $message): void
    {
        Log::debug("Recieved a message from {$message->author->username}: {$message->content}");
    }

    public static function isMyOwnMessage(Message $message, Discord $discord): boolean
    {
        return ($message->author->id == $discord->id);
    }

    public static function getGuildPrefix(Guild $guild): string
    {
        return Env::get('discord.prefix');
    }

    public static function isNotMyGuildPrefix(Message $message): boolean
    {
        self::$prefix = self::getGuildPrefix($message->channel->guild); // todo: check for prefix set by server
        Log::debug(sprintf('Prefix: %s', self::$prefix));
        
        return (!str_starts_with($message->content, self::$prefix));
    }

    public static function getCommands(): array
    {
        require self::$commandsFile;
    }

    public static function getAliasFromContent(string $content): string
    {
        return explode(' ', $content)[0];
    }

    public static function getNextContent(Message $message, String $substring): string
    {
        return trim(substr($message->content, strlen($substring)), ' ');
    }
}
