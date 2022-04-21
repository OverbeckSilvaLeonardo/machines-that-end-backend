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
}
