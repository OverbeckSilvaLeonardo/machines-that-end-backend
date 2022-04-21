<?php

namespace App\Domain\Machine\State;

class State
{
    private const POSSIBLE = [
        'awake',
        'working',
        'resting',
        'sleeping',
    ];

    private string $state;

    public function __construct(string $state)
    {
        if (!in_array($state, self::POSSIBLE)) {
            throw new \InvalidArgumentException('Invalid state type. Must be either awake, working, resting or sleeping.');
        }

        $this->state = $state;
    }


    public function getState(): string
    {
        return $this->state;
    }
}
