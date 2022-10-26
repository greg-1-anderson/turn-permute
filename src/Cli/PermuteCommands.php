<?php

namespace TurnPermute\Cli;

use TurnPermute\DataStructures\Set;
use TurnPermute\DataStructures\TurnSet;
use TurnPermute\Iterators\PermutationsIterator;
use TurnPermute\Stats\TurnSequenceStats;
use TurnPermute\Stats\BeforeAndAfterStats;
use TurnPermute\Stats\TurnOrderStats;
use TurnPermute\Stats\TurnRepetitivenessStats;
use Robo\Symfony\ConsoleIO;

class PermuteCommands extends \Robo\Tasks
{
    protected static function oneRound($turnOrderNumber, $reverse): array
    {
        $playerOrder = [];
        $otherPlayers = [2, 3];
        $otherPlayers = array_reverse($otherPlayers);

        switch ($turnOrderNumber) {
            case 1:
                $playerOrder = array_merge([1], $otherPlayers);
                break;

            case 2:
                $playerOrder = [$otherPlayers[1], 1, $otherPlayers[0]];
                break;

            case 3:
                $playerOrder = array_merge($otherPlayers, [1]);
                break;
        }
        return $playerOrder;
    }

    protected static function oneSet($setNumber): array
    {
        return [];
    }

    protected static function buildThreePlayerSequences(): array
    {
        $turnOrderGroups = Set::create([1,2,3]);

        $turnOrderList = $turnOrderGroups->getPermutations();
        return [];
    }
    /**
     * Do some permutations
     *
     * @command permute
     */
    public function permute(ConsoleIO $io, $players)
    {

        $exampleSet = Set::create([3, 5, 7]);
        $permutations = $exampleSet->getPermutations();

        print "====\n$permutations ====\n";

//        $playerTurnSequence = Set::create([3, 1, 2]);
        $playerTurnSequence = Set::create([4, 1, 3, 2]);
//        $playerTurnSequence = Set::create([6, 1, 5, 2, 4, 3]);
        $model = TurnSet::create($playerTurnSequence->rotations());

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
        $permutations = $model->getPermutations();
        foreach ($permutations as $key => $permutation) {
            print "$key => $permutation\n";
        }
*/

        $io->text("That's all it does for now.");
    }
}
