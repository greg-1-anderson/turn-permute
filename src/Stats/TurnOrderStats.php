<?php

namespace TurnPermute\Stats;

use TurnPermute\DataStructures\Set;
use TurnPermute\DataStructures\TurnSet;
use TurnPermute\DataStructures\CounterGroup;

/**
 * A collection of statistics about turn orders
 */
class TurnOrderStats
{
    protected array $roundStorage = [];
    protected $numberOfPlayers = 0;

    protected function __construct($numberOfPlayers)
    {
        $this->numberOfPlayers = $numberOfPlayers;
    }

    public static function create(TurnSet $turnSet)
    {
        $numberOfPlayers = 0;
        if ($turnSet->sizeOfSet() > 0) {
            $firstRound = $turnSet->first();
            $numberOfPlayers = $firstRound->sizeOfSet();
        }
        $stats = new TurnOrderStats($numberOfPlayers);

        foreach ($roundIter = $turnSet->getIterator() as $turnSequence) {
            $round = $roundIter->key();
            foreach ($turnSequence->getIterator() as $index => $turn) {
                $player = $index + 1;
                $stats->recordTurnStats($round, $player, $turn);
            }
        }

        return $stats;
    }

    public function recordTurnStats($round, $player, $turn)
    {
        // We do not care about the round; we simply want to
        // count how many times each player is in position $turn.
        $countTurns = $this->getStorage($player);
        $countTurns->accumulate($turn);
    }

    public function fair()
    {
        $values = [];

        // Combine the count of the number of times each player
        // is in each respective turn order.
        foreach ($this->roundStorage as $player => $playerStats) {
            $values = array_merge($values, $playerStats->values());
        }

        // If the sequence is fair, then all players will be in
        // every turn order the same number of times.
        $firstValue = reset($values);

        foreach ($values as $value) {
            if ($firstValue != $value) {
                return false;
            }
        }

        return true;
    }

    protected function getStorage($player): CounterGroup
    {
        if (!isset($this->roundStorage[$player])) {
            $this->roundStorage[$player] = new CounterGroup();

            for ($i = 1; $i <= $this->numberOfPlayers; ++$i) {
                $this->roundStorage[$player]->zero($i);
            }
        }

        return $this->roundStorage[$player];
    }
}
