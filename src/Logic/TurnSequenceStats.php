<?php

namespace TurnPermute\Logic;

/**
 * A collection of statistics about turn orders
 */
class TurnSequenceStats
{
    /** @var Set[] */
    public TurnSet $turnSet;

    protected function __construct(TurnSet $turnSet)
    {
        $this->turnSet = $turnSet;
    }

    public static function create(TurnSet $turnSet)
    {
        $stats = new TurnSequenceStats();

        return $stats;
    }

    /**
     * For each player, count how many times each other player
     * plays before, and how many times each other player plays after.
     */
    protected function calculateBeforeAndAfter()
    {
        $stats = new BeforeAndAfterStats();

        foreach ($roundIter = $this->turnSet->getIterator() as $turnSequence) {
            $stats->beginRoundStats($roundIter->key());
            foreach ($playerIter = $turnSequence->getIterator() as $player) {
                $stats->recordBeforeStats($player, $playerIter->getPastItems());
                $stats->recordAfterStats($player, $playerIter->getFutureItems());
            }
        }

        return $stats;
    }

    /**
     * A list of turn sequences is BALANCED if each player
     * goes BEFORE each other player the same number of
     * times as they go AFTER that same player.
     */
    public static function balanced(): bool
    {
        return true;
    }

    /**
     * A list of turn sequences is FAIR if each player
     * is in each turn order the same number of times
     * (i.e. they go first the same number of times that
     * they go second, last, etc).
     */
    public static function fair(): bool
    {
        return true;
    }

    /**
     * A list of turn sequences is NON REPETITIVE if
     * no player is ever in the same turn order for two
     * rounds in a row.
     */
    public static function nonRepetitive(): bool
    {
        return true;
    }

    public function __toString()
    {
        $result = '';

        foreach ($this->turnSequences as $set) {
            $result .= $set . PHP_EOL;
        }

        return $result;
    }
}
