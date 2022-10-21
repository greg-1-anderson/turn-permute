<?php

namespace TurnPermute\Iterators;

use TurnPermute\DataStructures\Set;

/**
 * An iterator over a Set, which returns in turn every permutation
 * of that Set.
 */
class PermutationsIterator implements \Iterator
{

    protected Set $data;
    protected SetIterator $iterator;
    protected PermutationsIterator|null $subPermutations;
    protected Set $current;
    protected $key;

    public function __construct(Set $data)
    {
        $this->data = $data;
        $this->iterator = $data->getIterator();

        $this->rewind();
    }

    /**
     * Rewind the iterator back to the first item
     */
    public function rewind(): void
    {
        $this->current = Set::create([]);
        $this->iterator->rewind();
        $this->key = 0;
        $this->beginSubPermutations();
        $this->prepareCurrent();
    }

    protected function beginSubPermutations()
    {
        $this->subPermutations = null;
        if (!$this->valid()) {
            return;
        }
        $this->subPermutations = new PermutationsIterator($this->iterator->getRemainingItems());
    }

    protected function prepareCurrent()
    {
        if (!$this->valid()) {
            return;
        }
        $firstItem = $this->iterator->current();
        $subPermutationSet = $this->subPermutations->current();
        $this->current = Set::create(array_merge([$firstItem], $subPermutationSet->asArray()));
    }

    /**
     * Return the value of the current item
     */
    public function current(): mixed
    {
        return $this->current;
    }

    public function key(): mixed
    {
        return $this->key;
    }

    public function next(): void
    {
        if (!$this->subPermutations) {
            return;
        }
        $this->key++;
        $this->subPermutations->next();
        if (!$this->subPermutations->valid()) {
            $this->iterator->next();
            if ($this->iterator->valid()) {
                $this->beginSubPermutations();
            }
        }
        $this->prepareCurrent();
    }

    public function valid(): bool
    {
        return $this->iterator->valid();
    }
}
