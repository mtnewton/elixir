<?php

require __DIR__.'/../vendor/autoload.php';

use MTNewton\Elixir\Helpers\Config;
use Dotenv\Dotenv;
use Discord\DiscordCommandClient;
use MTNewton\Elixir\Helpers\Commands;
use MTNewton\Elixir\Helpers\Log;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$discord = new DiscordCommandClient([
    'token' => Config::get('discord.token'),
    'prefix' => Config::get('discord.prefix'),
]);

Commands::register($discord);

Log::info('Starting Bot!');

$discord->run();