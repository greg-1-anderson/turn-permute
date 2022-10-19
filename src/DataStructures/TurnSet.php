<?php

namespace TurnPermute\DataStructures;

/**
 * A collection of sets representing the order players in
 * a game take their turn.
 *
 * The rows of sets represent the different rounds in the game.
 *
 * The INDEX ($key) of the element in each set represents the
 * player number. Index + 1 = player number, so the first element
 * ($key = 0) is player 1, the next is player 2, etc.
 *
 * The VALUE of the element in the set represents the turn
 * order for that player, e.g. if the first element has value
 * `4` in a four-element set, that would mean that player 1 moves
 * last this round.
 */
class TurnSet extends Set
{
    protected function __construct(array $turnSequences)
    {
        parent::__construct($turnSequences);
    }

    public static function createSetOfSize(int $players)
    {
        return TurnSet::create(Set::createRange(1, $players)->rotations());
    }

    public function swapIndexAndValue(): Set
    {
        throw new \RuntimeError('Cannot swap index and value when value of set is non-numeric.');
    }

    public function swapRowsAndColumns()
    {
        $arrayOfArrays = [];
        foreach ($this->getIterator() as $row) {
            $i = 0;
            foreach ($row->getIterator() as $item) {
                $arrayOfArrays[$i++][] = $item;
            }
        }

        $arrayOfSets = array_map(
            function ($item) {
                return Set::create($item);
            },
            $arrayOfArrays
        );

        return static::create($arrayOfSets);
    }

    public function __toString()
    {
        $result = '';

        foreach ($this->getIterator() as $set) {
            $result .= $set . PHP_EOL;
        }

        return $result;
    }
}
