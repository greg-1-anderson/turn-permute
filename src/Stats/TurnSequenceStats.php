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
    public function balanced(): bool
    {
        $stats = BeforeAndAfterStats::create($this->turnSet);

        return $stats->balanced();
    }

    /**
     * A list of turn sequences is FAIR if each player
     * is in each turn order the same number of times
     * (i.e. they go first the same number of times that
     * they go second, last, etc).
     */
    public function fair(): bool
    {
        $stats = TurnOrderStats::create($this->turnSet);

        return $stats->fair();
    }

    /**
     * A list of turn sequences is NON REPETITIVE if
     * no player is ever in the same turn order for two
     * rounds in a row.
     */
    public function nonRepetitive(): bool
    {
        $stats = TurnRepetitivenessStats::create($this->turnSet);

        return !$stats->repetitive();
    }

    public function __toString()
    {
        $items = [];
        if ($this->fair()) {
            $items[] = "Fair";
        }
        if ($this->balanced()) {
            $items[] = "Balanced";
        }
        if ($this->nonRepetitive()) {
            $items[] = "Non-repetitive";
        }

        if (empty($items)) {
            return "Neither Fair, Balanced, nor Non-repetitive";
        }

        return implode(', ', $items);
    }
}
