<?php

namespace TurnPermute\Logic;

/**
 * A collection of statistics about turn orders
 */
class TurnSequenceStats
{
    /** @var Set[] */
    public array $turnSequences;

    protected function __construct(Set $playerSet)
    {
        $this->turnSequences = $playerSet->rotations();
    }

    public static function create(TurnSet $turnSet)
    {
        $iter = $turnSet->getIterator();

        while ($iter->valid()) {
            $iter->next();
        }
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
