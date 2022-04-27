<?php

namespace App\Domain\Machine\State;

class State
{

    public const AWAKE = 'awake';
    public const WORKING = 'working';
    public const RESTING = 'resting';
    public const SLEEPING = 'sleeping';

    private const POSSIBLE = [
        self::AWAKE,
        self::WORKING,
        self::RESTING,
        self::SLEEPING,
    ];

    private string $state;

    public function __construct(string $state)
    {
        if (!in_array($state, self::POSSIBLE)) {
            throw new \InvalidArgumentException('Invalid state type. Must be either awake, working, resting or sleeping.');
        }

        $this->state = $state;
    }

    public static function fromString($state): State
    {
        return new State($state);
    }

    public function getState(): string
    {
        return $this->state;
    }
}
