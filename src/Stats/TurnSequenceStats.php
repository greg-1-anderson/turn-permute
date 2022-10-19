<?php

namespace TurnPermute\Stats;

use TurnPermute\DataStructures\Set;
use TurnPermute\DataStructures\TurnSet;

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
        $stats = new TurnSequenceStats($turnSet);

        return $stats;
    }

    /**
     * A list of turn sequences is BALANCED if each player
     * goes BEFORE each other player the same number of
     * times as they go AFTER that same player.
     */
    public static function balanced(): bool
    {
        $stats = BeforeAndAfterStats::create($this);

        return $stats->balanced();
    }

    /**
     * A list of turn sequences is FAIR if each player
     * is in each turn order the same number of times
     * (i.e. they go first the same number of times that
     * they go second, last, etc).
     */
    public static function fair(): bool
    {
        $stats = TurnOrderStats::create($this);

        return $status->fair();
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
