<?php

namespace TurnPermute\Cli;

use TurnPermute\DataStructures\Set;
use TurnPermute\DataStructures\TurnSet;
use TurnPermute\Logic\TurnSequenceStats;
use TurnPermute\Logic\BeforeAndAfterStats;
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
        $playerTurnSequence = Set::create([4, 1, 3, 2]);
        $model = TurnSet::createFromSet($playerTurnSequence);

        print $model;
        print "\n";

        $model->rotate();

        print $model;
        print "\n";

        //$stats = TurnSequenceStats::create($model);
        $result = BeforeAndAfterStats::create($model);
        var_export($result);

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
