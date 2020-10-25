<?php

require __DIR__ . '/../vendor/autoload.php';

use Discord\Discord;
use MTNewton\Elixir\Helpers\Env;
use Dotenv\Dotenv;
use MTNewton\Elixir\Helpers\Commands;
use MTNewton\Elixir\Helpers\Log;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$discord = new Discord([
    'token' => Env::get('discord.token'),
]);

$discord->on('ready', function ($discord) {
    // $discord->on('message', function ($message) {
    //     Log::debug("Recieved a message from {$message->author->username}: {$message->content}");
    // });
    Commands::register($discord); 
    Log::info('Bot is ready!');
});


Log::info('Starting Bot!');

$discord->run();
