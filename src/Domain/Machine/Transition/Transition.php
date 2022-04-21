<?php

namespace App\Domain\Machine\Transition;

class Transition
{
    private const POSSIBLE = [
        '08:00',
        '12:00',
        '13:00',
        '18:00',
        '22:00',
    ];

    private string $transition;
}
