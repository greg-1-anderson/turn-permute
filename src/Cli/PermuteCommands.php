<?php

namespace TurnPermute\Cli;

use TurnPermute\DataStructures\Set;
use TurnPermute\DataStructures\TurnSet;
use TurnPermute\Stats\TurnSequenceStats;
use TurnPermute\Stats\BeforeAndAfterStats;
use TurnPermute\Stats\TurnOrderStats;
use TurnPermute\Stats\TurnRepetitivenessStats;
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
//        $playerTurnSequence = Set::create([3, 1, 2]);
        $playerTurnSequence = Set::create([4, 1, 3, 2]);
//        $playerTurnSequence = Set::create([6, 1, 5, 2, 4, 3]);
        $model = TurnSet::createFromSet($playerTurnSequence);

        print $model;
        print "\n";

        $model->swapRowsAndColumns();

        print $model;
        print "\n";

        //$stats = TurnSequenceStats::create($model);
        $result = BeforeAndAfterStats::create($model);
        print "Balanced: ";
        var_export($result->balanced());
        print "\n";


        $result = TurnOrderStats::create($model);
        print "Fair: ";
        var_export($result->fair());
        print "\n";


        $result = TurnRepetitivenessStats::create($model);
        print "Repetitive: ";
        var_export($result->repetitive());
        print "\n";

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
