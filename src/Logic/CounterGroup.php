<?php

namespace TurnPermute\Logic;

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

    public function accumulate($key)
    {
        if (!isset($this->counters[$key])) {
            $this->counters[$key] = 0;
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
}
