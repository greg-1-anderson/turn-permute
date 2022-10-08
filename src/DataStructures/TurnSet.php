<?php

namespace TurnPermute\DataStructures;

/**
 * A collection of sets representing the order players in
 * a game take their turn.
 */
class TurnSet
{
    /** @var Set[] */
    public array $turnSequences;

    protected function __construct(Set $playerSet)
    {
        $this->turnSequences = $playerSet->rotations();
    }

    public static function createFromSet(Set $playerSet)
    {
        return new TurnSet($playerSet);
    }

    public static function create(int $players)
    {
        return TurnSet::createFromSet(Set::createRange(1, $players));
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
