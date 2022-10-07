<?php

namespace TurnPermute\DataStructures;

class Set
{
    protected array $elements;

    protected function __construct(array $elements)
    {
        $this->elements = array_combine($elements, $elements);        
    }

    /**
     * Create a set from the values of an array.
     *
     * @param array $elements
     *   The values from the provided array will be used to create the set.
     */
    public static function create(array $elements): Set
    {
        return new Set($elements);
    }

    /**
     * Create a set from a range of values.
     *
     * @param string|int|float $start
     *   The value of the first element in the set.
     * @param string|int|float $end
     *   The value of the last element in the set.
     * @param int|float $step
     *   The increment between each value in the set.
     */
    public static function createRange(string|int|float $start, string|int|float $end, int|float $step = 1)
    {
        return new Set(range($start, $end, $step));
    }

    /**
     * Return an itererator over the values in the set. Both the
     * key and the value of the iterator will hold the value from
     * the element in the set.
     *
     * @return \ArrayIterator elements of the set
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->elements);
    }

    /**
     * Return an itererator over the values in the set. The key
     * will contain the value from the set, and the value will
     * be an array containing all of the other elements in the set.
     *
     * @return \ArrayIterator elements of the set
     */
    public function getPartialsIterator(): \ArrayIterator
    {
        return new \ArrayIterator(
            array_map(
                function($item) {
                    return Set::create(array_diff($this->elements, [$item]));
                },
                $this->elements
            )
        );
    }

    /**
     * Return all of the permutations of this set as a list of sets.
     *
     * @return Set[]
     */
    public function permutations(): array
    {
        if ($this->sizeOfSet() <= 1) {
            return [$this];
        }

        $result = [];

        foreach ($this->getPartialsIterator() as $value => $partials) {
            $partialPermutations = $partials->permutations();
            foreach ($partialPermutations as $partialPermutation) {
                $result[] = Set::create(array_merge([$value], $partialPermutation->asArray()));
            }
        }

        return $result;
    }

    /**
     * @return array
     */
    public function asArray()
    {
        return $this->elements;
    }

    /**
     * @return int
     */
    public function sizeOfSet()
    {
        return count($this->elements);
    }
}
