<?php

namespace TurnPermute\DataStructures;

/**
 * An iterator over a Set, which provides access to the
 * previous and next items in the iteration (with wraparound),
 * and also accounts for which items have and have not been
 * visited.
 */
class SetIterator implements \Iterator
{

    protected Set $data;
    protected \Iterator $iterator;
    protected \Iterator $nextIterator;
    protected mixed $previous;
    protected array $past;
    protected array $future;

    public function __construct(Set $data)
    {
        $this->data = $data;
        $this->iterator = new \ArrayIterator($data->asArray());

        $this->rewind();
    }

    public function rewind(): void
    {
        $this->iterator->rewind();
        $this->previous = $this->data->last();
        $this->past = [];
        $this->future = $this->data->asArray();
        array_shift($this->future);
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

    public function getPastItems(): array
    {
        return $this->past;
    }

    public function getFutureItems(): array
    {
        return $this->future;
    }

    public function partials(): Set
    {
        return Set::create(array_merge($this->getPastItems(), $this->getFutureItems()));
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
        $this->past[] = $this->previous;
        array_shift($this->future);
    }

    public function valid(): bool
    {
        return $this->iterator->valid();
    }
}
