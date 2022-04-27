<?php

namespace App\Domain\Machine\Transition;


class Transition
{
    private const EIGHT = '08:00';
    private const TWELVE = '12:00';
    private const THIRTEEN = '13:00';
    private const EIGHTEEN = '18:00';
    private const TWENTY_TWO = '22:00';

    private const POSSIBLE = [
        self::EIGHT,
        self::TWELVE,
        self::THIRTEEN,
        self::EIGHTEEN,
        self::TWENTY_TWO,
    ];

    private string $transition;

    private function __construct(string $transition)
    {
        if (!in_array($transition, self::POSSIBLE)) {
            throw new \InvalidArgumentException('Invalid transition type.');
        }

        $this->transition = $transition;
    }

    public static function fromString(string $transition): Transition
    {
        return new Transition($transition);
    }

    public function getTransition(): string
    {
        return $this->transition;
    }

    public function isEight(): bool
    {
        return $this->getTransition() == self::EIGHT;
    }

    public function isTwelve(): bool
    {
        return $this->getTransition() == self::TWELVE;
    }

    public function isThirteen(): bool
    {
        return $this->getTransition() == self::THIRTEEN;
    }

    public function isEighteen(): bool
    {
        return $this->getTransition() == self::EIGHTEEN;
    }

    public function isTwentyTwo(): bool
    {
        return $this->getTransition() == self::TWENTY_TWO;
    }

}
