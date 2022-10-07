<?php

namespace TurnPermute\Cli;

use Robo\Symfony\ConsoleIO;

class PermuteCommands extends \Robo\Tasks
{
    /**
     * Do some permutations
     *
     * @command permute
     */
    public function permute(ConsoleIO $io, $players)
    {
        $model = new \TurnPermute\Example($players);

        $io->text("Does not do anything yet");
    }
}
