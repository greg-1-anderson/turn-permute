<?php

namespace TurnPermute\Iterators;

use PHPUnit\Framework\TestCase;
use TurnPermute\DataStructures\Set;

class SetIteratorTest extends TestCase
{
    public function testSetIterator()
    {
        $setUnderTest = Set::create([3, 5, 7]);

        $iter = $setUnderTest->getIterator();

        $this->assertTrue($iter->valid());
        $this->assertEquals(0, $iter->key());
        $this->assertEquals(3, $iter->current());
        $this->assertEquals(7, $iter->getPreviousItem());
        $this->assertEquals(5, $iter->getNextItem());
        $this->assertEquals([], $iter->getPastItems()->asArray());
        $this->assertEquals([5, 7], $iter->getFutureItems()->asArray());
        $this->assertEquals([5, 7], $iter->getRemainingItems()->asArray());

        $iter->next();

        $this->assertTrue($iter->valid());
        $this->assertEquals(1, $iter->key());
        $this->assertEquals(5, $iter->current());
        $this->assertEquals(3, $iter->getPreviousItem());
        $this->assertEquals(7, $iter->getNextItem());
        $this->assertEquals([3], $iter->getPastItems()->asArray());
        $this->assertEquals([7], $iter->getFutureItems()->asArray());
        $this->assertEquals([3, 7], $iter->getRemainingItems()->asArray());

        $iter->next();

        $this->assertTrue($iter->valid());
        $this->assertEquals(2, $iter->key());
        $this->assertEquals(7, $iter->current());
        $this->assertEquals(5, $iter->getPreviousItem());
        $this->assertEquals(3, $iter->getNextItem());
        $this->assertEquals([3, 5], $iter->getPastItems()->asArray());
        $this->assertEquals([], $iter->getFutureItems()->asArray());
        $this->assertEquals([3, 5], $iter->getRemainingItems()->asArray());

        $iter->next();
        $this->assertFalse($iter->valid());
        $this->assertEquals([3, 5, 7], $iter->getPastItems()->asArray());
        $this->assertEquals([], $iter->getFutureItems()->asArray());
    }
}
