<?php

namespace TurnPermute\Stats;

use PHPUnit\Framework\TestCase;

use TurnPermute\DataStructures\Set;
use TurnPermute\DataStructures\TurnSet;

class TurnSequenceStatsTest extends TestCase
{
    /**
     * Test TurnSequenceStats.
     *
     * @dataProvider turnSequenceStatsTestValues
     */
    public function testTurnSequenceStats($expected, $playerTurnSequence)
    {
        $set = Set::create($playerTurnSequence);
        $model = TurnSet::create($set->rotations());
        $stats = TurnSequenceStats::create($model);
        $this->assertEquals($expected, (string) $stats);
    }

    /**
     * Data provider for testTurnSequenceStats.
     */
    public function turnSequenceStatsTestValues()
    {
        return [
            ['Fair, Non-repetitive', []],
            ['Fair, Non-repetitive', [3, 1, 2]],
            ['Fair, Balanced, Non-repetitive', [4, 1, 3, 2]],
            ['Fair, Non-repetitive', [5, 1, 4, 2, 3]],
            ['Fair, Balanced, Non-repetitive', [6, 1, 5, 2, 4, 3]],
        ];
    }
}
