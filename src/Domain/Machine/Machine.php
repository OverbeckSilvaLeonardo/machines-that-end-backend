<?php

namespace App\Domain\Machine;


use App\Domain\Machine\State\State;
use App\Domain\Machine\State\StateCollection;
use App\Domain\Machine\Transition\TransitionCollection;

class Machine
{
    private StateCollection $possibleStates;
    private State $currentState;

    private TransitionCollection $possibleTransitions;
}
