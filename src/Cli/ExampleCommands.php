<?php

namespace TurnPermute\Cli;

use Robo\Symfony\ConsoleIO;

class ExampleCommands extends \Robo\Tasks
{
    /**
     * Multiply two numbers together
     *
     * @command multiply
     */
    public function multiply(ConsoleIO $io, $a, $b)
    {
        $model = new \TurnPermute\Example($a);
        $result = $model->multiply($b);

        $io->text("$a times $b is $result");
    }
}
