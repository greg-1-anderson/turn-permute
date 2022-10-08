<?php

namespace TurnPermute\DataStructures;

/**
 * A collection of sets representing the order players in
 * a game take their turn.
 *
 * The INDEX of the element in the set represents the player
 * number.
 *
 * The VALUE of the element in the set represents thier
 * turn order.
 */
class TurnSet
{
    /** @var Set[] A set of sets (turn sequences) */
    public Set $turnSequences;

    protected function __construct(Set $turnSequence)
    {
        $this->turnSequences = Set::create($turnSequence->rotations());
    }

    public static function createFromSet(Set $turnSequence)
    {
        return new TurnSet($turnSequence);
    }

    public static function create(int $players)
    {
        return TurnSet::createFromSet(Set::createRange(1, $players));
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
