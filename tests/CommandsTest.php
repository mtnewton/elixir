<?php

use MTNewton\Elixir\Helpers\Commands;

use Tests\TestCase;

class CommandsTest extends TestCase
{
    /**
     * @test
     */
    public function getCommandToRun()
    {
        $expected = '';
        $actual = Commands::getCommandToRun('help');
        $this->assertEquals($actual, $expected);
    }
}