<?php

namespace App\Domain\Machine;

class State
{
    private const POSSIBLE = [
        'awake',
        'working',
        'resting',
        'sleeping',
    ];
}
