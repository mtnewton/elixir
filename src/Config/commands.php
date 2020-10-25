<?php

use MTNewton\Elixir\Commands\HelpCommand;
use MTNewton\Elixir\Commands\PingCommand;
use MTNewton\Elixir\Commands\SayCommand;
use MTNewton\Elixir\Commands\TimeCommand;

return [
    PingCommand::class,
    SayCommand::class,
    TimeCommand::class,
    HelpCommand::class,
];