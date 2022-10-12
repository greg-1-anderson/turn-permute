<?php

namespace TurnPermute\Logic;

use TurnPermute\DataStructures\Set;

/**
 * A collection of statistics about turn orders
 */
class BeforeAndAfterStorage
{
    protected CounterGroup $playersBefore;
    protected CounterGroup $playersAfter;

    public function __construct()
    {
        $this->playersBefore = new CounterGroup();
        $this->playersAfter = new CounterGroup();
    }

    public function beforeCount()
    {
        return $this->playersBefore->values();
    }

    public function afterCount()
    {
        return $this->playersAfter->values();
    }

    public function recordBeforeStats(Set $playersBefore)
    {
        foreach ($playersBefore->getIterator() as $player) {
            $this->playersBefore->accumulate($player);
        }
    }

    public function recordAfterStats(Set $playersAfter)
    {
        foreach ($playersAfter->getIterator() as $player) {
            $this->playersAfter->accumulate($player);
        }
    }
}
