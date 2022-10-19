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
class TurnSet
{
    /** @var Set A set of sets (turn sequences) */
    public Set $turnSequences;

    protected function __construct(Set $turnSequences)
    {
        $this->turnSequences = $turnSequences;
    }

    public static function createFromArrayOfSets(array $turnSequences)
    {
        // @todo: Check if all elements of $turnSequences are Sets, throw if not.
        return new TurnSet(Set::create($turnSequences));
    }

    public static function createFromSet(Set $turnSequence)
    {
        return static::createFromArrayOfSets($turnSequence->rotations());
    }

    public static function create(int $players)
    {
        return TurnSet::createFromSet(Set::createRange(1, $players));
    }

    /**
     * Return the first item in the set
     */
    public function first(): Set
    {
        return $this->turnSequences->first();
    }

    /**
     * Return the last item in the set
     */
    public function last(): Set
    {
        return $this->turnSequences->last();
    }

    public function rotate()
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

        return static::createFromArrayOfSets($arrayOfSets);
    }

    /**
     * Return an itererator over the turn sequences in the list
     *
     * @return \ArrayIterator turn sequences of the set
     */
    public function getIterator(): \Iterator
    {
        return $this->turnSequences->getIterator();
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
