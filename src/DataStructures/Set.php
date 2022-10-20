<?php

namespace TurnPermute\DataStructures;

/**
 * An immutable set of objects.
 */
class Set
{
    protected array $elements;

    protected function __construct(array $elements)
    {
        $this->elements = array_values($elements);
    }

    /**
     * Create a set from the values of an array.
     *
     * @param array $elements
     *   The values from the provided array will be used to create the set.
     */
    public static function create(array $elements): Set
    {
        return new static($elements);
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
     * Return the first item in the set
     */
    public function first(): mixed
    {
        return reset($this->elements);
    }

    /**
     * Return the last item in the set
     */
    public function last(): mixed
    {
        return end($this->elements);
    }

    /**
     * @return int
     */
    public function sizeOfSet(): int
    {
        return count($this->elements);
    }

    /**
     * Return an itererator over the values in the set. Both the
     * key and the value of the iterator will hold the value from
     * the element in the set.
     *
     * n.b. This returns a SetIterator, which provides getPreviousItem()
     * and getNextItem() methods for examining adjacent items in the set.
     *
     * @return \ArrayIterator elements of the set
     */
    public function getIterator(): SetIterator
    {
        return new SetIterator($this);
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

        foreach ($iter = $this->getIterator() as $value) {
            $partialPermutations = $iter->getRemainingItems()->permutations();
            foreach ($partialPermutations as $partialPermutation) {
                $result[] = static::create(array_merge([$value], $partialPermutation->asArray()));
            }
        }

        return $result;
    }

    /**
     * Swaps the index and key values. Assumes that they
     * keys are zero-based, and the values are one-based.
     * Also assumes that keys will range from zero to N - 1,
     * and values will range from 1 to N.
     *
     * If the assumptions are not met in the input set,
     * the result set will be normalized to conform.
     *
     * @return Set
     *   Indexes are now ordered by the previous VALUE minus one,
     *   and the new values will be the former index position plus one.
     */
    public function swapIndexAndValue(): Set
    {
        $swapped = [];
        foreach ($this->asArray() as $key => $value) {
            $swapped[$value] = $key + 1;
        }

        ksort($swapped, SORT_NUMERIC);

        return static::create(array_values($swapped));
    }

    /**
     * Swaps rows and columns. The first row will contain the values of all
     * of the first elements from the rows of the source Set, the second row
     * will contain all of the second elements, and so on.
     *
     * @return Set
     *   New set with rows and columns swapped.
     */
    public function swapRowsAndColumns()
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

        return static::create($arrayOfSets);
    }

    /**
     * Returns the same Set with all elements shifted by an offset.
     *
     * @param int $step
     *   How many elements to rotate through in one step
     * @return Set
     */
    public function rotate(int $step = 1): Set
    {
        // Range-test our parameter
        if (abs($step) >= $this->sizeOfSet()) {
            throw new \Exception('Step is ' . $step . ', but it cannot be greater than or equal to the number of elements in the set, which is ' . $this->sizeOfSet());
        }

        // Negative steps roll the other way
        if ($step < 0) {
            $step = $this->sizeOfSet() + $step;
        }

        $begin = array_slice($this->elements, $step);
        $end = array_slice($this->elements, 0, $step);

        return static::create(array_merge($begin, $end));
    }

    /**
     * Return all of the rotations of this set.
     * (Not guarenteed to work for steps other than 1).
     *
     * @param int $step
     *   How many elements to rotate through in one step
     * @return Set
     */
    public function rotations(int $step = 1): array
    {
        $result = [];
        $rotated = $this;

        for ($i = 0; $i < $this->sizeOfSet(); ++$i) {
            $result[] = $rotated;
            $rotated = $rotated->rotate($step);
        }

        return $result;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        // Avoid extra whitespace with empty sets
        if (!$this->sizeOfSet()) {
            return '[]';
        }

        return "[ " . implode(', ', $this->elements) . " ]";
    }

    /**
     * @return array
     */
    public function asArray(): array
    {
        return $this->elements;
    }
}
