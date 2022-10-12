<?php

namespace TurnPermute\DataStructures;

use PHPUnit\Framework\TestCase;

class SetTest extends TestCase
{
    /**
     * Test creation of Set objects.
     *
     * @dataProvider setTestValues
     */
    public function testCreateSet($expected, $constructor_parameter)
    {
        $set = Set::create($constructor_parameter);
        $this->assertEquals($expected, (string) $set);
    }

    /**
     * Test rotation of Set objects.
     *
     * @dataProvider rotateSetTestValues
     */
    public function testRotatSet($expected, $constructor_parameter)
    {
        $set = Set::create($constructor_parameter);
        $permutations = $set->rotations();
        $this->assertEquals($expected, implode("\n", $permutations));
    }

    /**
     * Test swapping index and values of Set objects.
     *
     * @dataProvider swapIndexAndValueTestValues
     */
    public function testSwapIndexAndValue($expected, $constructor_parameter)
    {
        $set = Set::create($constructor_parameter);
        $swapped = $set->swapIndexAndValue();
        $this->assertEquals($expected, (string) $swapped);
    }

    /**
     * Test creation of Set objects.
     *
     * @dataProvider permuteSetTestValues
     */
    public function testPermuteSet($expected, $constructor_parameter)
    {
        $set = Set::create($constructor_parameter);
        $permutations = $set->permutations();
        $this->assertEquals($expected, implode("\n", $permutations));
    }

    /**
     * Data provider for testCreateSet.
     */
    public function setTestValues()
    {
        return [
            ['[]', []],
            ['[ 1, 2, 3 ]', [1, 2, 3]],
        ];
    }

    /**
     * Data provider for testPermuteSet.
     */
    public function rotateSetTestValues()
    {
        return [
            ['', []],
            [
'[ 1, 2, 3 ]
[ 2, 3, 1 ]
[ 3, 1, 2 ]',
                [1, 2, 3]
            ],
        ];
    }

    /**
     * Data provider for testSwapIndexAndValue.
     */
    public function swapIndexAndValueTestValues()
    {
        return [
            ['[]', []],
            ['[ 2, 4, 3, 1 ]', [4, 1, 3, 2]],
            ['[ 1, 2, 3, 4 ]', [1, 2, 3, 4]],
            ['[ 3, 2, 1 ]', [5, 3, 2]],
        ];
    }

    /**
     * Data provider for testPermuteSet.
     */
    public function permuteSetTestValues()
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
