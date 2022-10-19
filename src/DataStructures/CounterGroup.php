<?php

namespace TurnPermute\Datastructures;

/**
 * A collection of statistics about turn orders
 */
class CounterGroup
{
    protected array $counters;

    public function __construct()
    {
        $this->counters = [];
    }

    public function zero($key)
    {
        $this->counters[$key] = 0;
    }

    public function accumulate($key)
    {
        if (!isset($this->counters[$key])) {
            $this->zero($key);
        }
        $this->counters[$key]++;
    }

    public function value($key)
    {
        if (!isset($this->counters[$key])) {
            return 0;
        }
        return $this->counters[$key];
    }

    public function values()
    {
        return $this->counters;
    }
}
