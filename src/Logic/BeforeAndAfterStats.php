<?php

namespace TurnPermute\Logic;

use TurnPermute\DataStructures\Set;
use TurnPermute\DataStructures\TurnSet;

/**
 * A collection of statistics about turn orders
 */
class BeforeAndAfterStats
{
    protected const OVERALL = -1;
    protected array $roundStorage = [];

    protected function __construct()
    {
    }

    public static function create(TurnSet $turnSet)
    {
        $stats = new BeforeAndAfterStats();

        foreach ($roundIter = $turnSet->getIterator() as $turnSequence) {
            $round = $roundIter->key();
            $playerSequence = $turnSequence->swapIndexAndValue();
            foreach ($playerIter = $playerSequence->getIterator() as $player) {
                $stats->recordBeforeStats($round, $player, $playerIter->getPastItems());
                $stats->recordAfterStats($round, $player, $playerIter->getFutureItems());
            }
        }

        return $stats;
    }

    public function recordBeforeStats($round, $player, Set $playersBefore)
    {
        $this->getStorage(self::OVERALL, $player)->recordBeforeStats($playersBefore);
        // @todo: Do we need to keep statistics about the round-by-round before and after stats?
        // If not, we could remove the $round parameter from getStorage and eliminate OVERALL
        // $this->getStorage($round, $player)->recordBeforeStats($playersBefore);
    }

    public function recordAfterStats($round, $player, Set $playersAfter)
    {
        $this->getStorage(self::OVERALL, $player)->recordAfterStats($playersAfter);
        // $this->getStorage($round, $player)->recordAfterStats($playersAfter);
    }

    protected function getStorage($round, $player): BeforeAndAfterStorage
    {
        if (!isset($this->roundStorage[$round][$player])) {
            $this->roundStorage[$round][$player] = new BeforeAndAfterStorage();
        }

        return $this->roundStorage[$round][$player];
    }
}
