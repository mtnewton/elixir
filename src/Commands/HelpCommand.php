<?php

namespace MTNewton\Elixir\Commands;

use Carbon\Carbon;
use Exception;
use MTNewton\Elixir\Helpers\Commands;
use MTNewton\Elixir\Helpers\Log;

class HelpCommand extends Command
{
    public static function getAliases() 
    {
        return [
            'help',
            'h',
            'commands',
        ];
    }

    public static function getDescription()
    {
        return 'A list of available commands, optionally pass a specific command';
    }

    public function execute()    
    {
        $content = $this->getContentWithoutCommands();
        Log::debug('Content: ' . $content);

        $commands = require __DIR__ . '/../Config/commands.php';

        if (empty($content)) {
            Log::debug("Running top level help command");
            return $this->formatHelpOutput($this->getCommandInfo($commands));
        }

        $command = $this->findMatchingCommand($content, $commands);
        if (!$command) {
            return "Unknown command";
        }

        return $this->formatHelpOutput($this->getCommandInfo([$command]), true);
    }

    protected function getCommandInfo(array $commands) 
    {
        $list = [];

        foreach ($commands as $command) {
            Log::debug('Listing command ' . $command);
            $list[$command::getAliases()[0]] = [
                'class' => $command,
                'aliases' => array_diff($command::getAliases(), [$command::getAliases()[0]]),
                'description' => $command::getDescription(),
                'hasSubcommands' => !!$command::getSubCommands(),
            ];
        }
        Log::debug('Command info: ' . json_encode($list));
        return $list;
    }

    protected function findMatchingCommand($content, $commands)
    {
        $aliases = explode(' ', $content);

        while(!empty($commands)) {
            foreach ($commands as $command) {
                if ($command::matchesAlias($aliases[0] , $content)) {
                    $content = trim(substr($content, strlen($aliases[0])), ' ');
                    array_splice($aliases, 0, 1);
                    if (empty($aliases)) {
                        return $command;
                    }
                    $commands = $command::getSubCommands();
                    continue 2;
                }
            }
            break;
        }

        return null;
    }

    protected function formatHelpOutput(array $commandInfo, bool $specificCommand = false)
    {
        $content = $this->getContentWithoutCommands();
        $output = "Available commands\n```";
        if ($specificCommand) {
            $output = 'Help information for command: ' . $this->getContentWithoutCommands() . "\n```";
        }
        foreach ($commandInfo as $command => $info) {
            $output .= "\n{$command}: {$info['description']}\n";
            if ($info['aliases']) {
                $output .= "\taliases: " . implode(', ', $info['aliases']) . "\n";
            }
            if (!$specificCommand && $info['hasSubcommands']) {
                $output .= "\tThis command has subcommands, check: " . 
                    Commands::getGuildPrefix($this->message->channel->guild) . 
                    'help ' . ($content ? $content . ' ' : '') . "{$command}\n";
            }
            if ($specificCommand && $info['hasSubcommands']) {
                $output .= "\tsubcommands: ";
                $subcommandList = [];
                foreach ($info['class']::getSubCommands() as $subcommand) {
                    $subcommandList[] = $subcommand::getAliases()[0];
                }
                $output .= implode(', ', $subcommandList) . "\n";
            }
        }
        return $output . '```';
    }
}
