<?php

namespace TurnPermute\Stats;

use TurnPermute\DataStructures\Set;
use TurnPermute\DataStructures\TurnSet;
use TurnPermute\DataStructures\CounterGroup;

/**
 * A collection of statistics about turn orders
 */
class TurnRepetitivenessStats
{
    protected array $repetitionStorage = [];

    protected function __construct()
    {
    }

    public static function create(TurnSet $turnSet)
    {
        $previousRound = $turnSet->last();
        $stats = new TurnRepetitivenessStats();

        foreach ($roundIter = $turnSet->getIterator() as $turnSequence) {
            $round = $roundIter->key();
            $previousRoundSequence = $previousRound->getIterator();
            foreach ($turnSequence->getIterator() as $index => $turn) {
                $player = $index + 1;
                $previousRoundTurn = $previousRoundSequence->current();
                $previousRoundSequence->next();

                if ($turn == $previousRoundTurn) {
                    $stats->recordTurnOrderRepetition($round, $player, $turn);
                }
            }

            $previousRound = $turnSequence;
        }

        return $stats;
    }

    public function recordTurnOrderRepetition($round, $player, $turn)
    {
        $this->repetitionStorage[] = ['r' => $round, 'p' => $player, 't' => $turn];
    }

    public function repetitive()
    {
        return !empty($this->repetitionStorage);
    }
}
