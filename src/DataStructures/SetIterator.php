<?php

namespace TurnPermute\DataStructures;

/**
 * An iterator over a Set, which provides access to the
 * previous and next items in the iteration (with wraparound).
 */
class SetIterator implements \Iterator
{

    protected Set $data;
    protected \Iterator $iterator;
    protected \Iterator $nextIterator;
    protected mixed $previous;

    public function __construct(Set $data, \ArrayIterator $iterator)
    {
        $this->data = $data;
        $this->iterator = $iterator;

        $this->rewind();
    }

    public function rewind(): void
    {
        $this->iterator->rewind();
        $this->previous = $this->data->last();
        $this->nextIterator = clone $this->iterator;
        $this->nextIterator->next();
    }

    public function current(): mixed
    {
        return $this->iterator->current();
    }

    public function getPreviousItem(): mixed
    {
        return $this->previous;
    }

    public function getNextItem(): mixed
    {
        if (!$this->nextIterator->valid()) {
            return $this->data->first();
        }

        return $this->nextIterator->current();
    }

    public function key(): mixed
    {
        return $this->iterator->key();
    }

    public function next(): void
    {
        $this->previous = $this->current();
        $this->iterator->next();
        $this->nextIterator->next();
    }

    public function valid(): bool
    {
        return $this->iterator->valid();
    }
}
