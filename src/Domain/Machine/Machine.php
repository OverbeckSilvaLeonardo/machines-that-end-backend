<?php

namespace App\Domain\Machine;


use App\Domain\Machine\State\State;
use App\Domain\Machine\State\StateCollection;
use App\Domain\Machine\Transition\Transition;
use App\Domain\Machine\Transition\TransitionCollection;

class Machine
{
    private State $currentState;
    private StateCollection $possibleStates;
    private TransitionCollection $possibleTransitions;

    public function __construct(StateCollection $possibleStates, TransitionCollection $possibleTransitions)
    {
        $this->possibleStates = $possibleStates;
        $this->possibleTransitions = $possibleTransitions;

        $this->currentState = $possibleStates->getFirst();
    }

    public function applyTransition(Transition $transition): State
    {
        if (!$this->possibleTransitions->has($transition)) {
            throw new \InvalidArgumentException('The transition sent is not possible on this machine.');
        }

        $this->currentState = $this->possibleStates->getNext($this, $transition);

        return $this->currentState;
    }

    public function getPossibleTransitions(): TransitionCollection
    {
        return $this->possibleTransitions;
    }
}
