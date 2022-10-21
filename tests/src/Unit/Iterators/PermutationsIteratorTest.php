<?php

namespace TurnPermute\Iterators;

use PHPUnit\Framework\TestCase;
use TurnPermute\DataStructures\Set;

class PermutationsIteratorTest extends TestCase
{
    /**
     * Test PermutationsIterator
     *
     * @dataProvider permutationsIteratorTestValues
     */
    public function testPermutationsIterator($expected, $setUnderTest)
    {
        $sut = Set::create($setUnderTest);
        $permutations = new PermutationsIterator($sut);

        $this->assertEquals($expected, rtrim((string) $permutations, "\n"));
    }

    /**
     * Data provider for testPermutationsIterator.
     */
    public function permutationsIteratorTestValues()
    {
        return [
            ['[]', []],
            [
'[ 1, 2, 3 ]
[ 1, 3, 2 ]
[ 2, 1, 3 ]
[ 2, 3, 1 ]
[ 3, 1, 2 ]
[ 3, 2, 1 ]',
                [1, 2, 3],
            ],

            [
'[ 1, 2, 3, 4 ]
[ 1, 2, 4, 3 ]
[ 1, 3, 2, 4 ]
[ 1, 3, 4, 2 ]
[ 1, 4, 2, 3 ]
[ 1, 4, 3, 2 ]
[ 2, 1, 3, 4 ]
[ 2, 1, 4, 3 ]
[ 2, 3, 1, 4 ]
[ 2, 3, 4, 1 ]
[ 2, 4, 1, 3 ]
[ 2, 4, 3, 1 ]
[ 3, 1, 2, 4 ]
[ 3, 1, 4, 2 ]
[ 3, 2, 1, 4 ]
[ 3, 2, 4, 1 ]
[ 3, 4, 1, 2 ]
[ 3, 4, 2, 1 ]
[ 4, 1, 2, 3 ]
[ 4, 1, 3, 2 ]
[ 4, 2, 1, 3 ]
[ 4, 2, 3, 1 ]
[ 4, 3, 1, 2 ]
[ 4, 3, 2, 1 ]',
                [1, 2, 3, 4],
            ],
        ];
    }
}
