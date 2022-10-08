<?php

namespace TurnPermute\Cli;

use TurnPermute\DataStructures\Set;
use TurnPermute\DataStructures\TurnSet;
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
        $model = TurnSet::create($players);

        print $model;

/*
        $model = Set::createRange(1, $players);

        print $model . PHP_EOL;
        $rotatedModel = $model->rotate();
        print $rotatedModel . PHP_EOL;

        // Print permutations
        $permutations = $model->permutations();
        foreach ($permutations as $key => $permutation) {
            print "$key => $permutation\n";
        }
*/

        $io->text("That's all it does for now.");
    }
}
