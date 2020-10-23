<?php

namespace MTNewton\Elixir\Helpers;

use Discord\DiscordCommandClient;

class Commands
{
    public static function register(DiscordCommandClient $discord)
    {
        $commands = require __DIR__.'/../commands.php';

        foreach ($commands as $command) {
            Log::debug('Registering command: ' . $command);
            $commandInstance = $discord->registerCommand(
                $command::getCommandName(), 
                [$command, 'execute'],
                [
                    'description' => $command::getDescription(),
                    'aliases' => $command::getAliases(),
                ]
            );
            foreach ($command::getSubCommands() as $subCommand) {
                Log::debug('Registering subcommand: ' . $subCommand);
                $commandInstance->registerSubCommand(
                    $subCommand::getCommandName(), 
                    [$subCommand, 'execute'],
                    [
                        'description' => $subCommand::getDescription(),
                        'aliases' => $subCommand::getAliases(),
                    ]
                );
            }
        }
    }
}
