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

    public function toArray(): array
    {
        return [
            'current_state' => $this->currentState->getState(),
            'possible_states' => array_map(fn (State $state) => $state->getState(), $this->possibleStates->getStates()),
            'possible_transitions' => array_map(fn (Transition $state) => $state->getTransition(), $this->possibleTransitions->getTransitions())
        ];
    }

    private function __construct(StateCollection $possibleStates, TransitionCollection $possibleTransitions)
    {
        $this->possibleStates = $possibleStates;
        $this->possibleTransitions = $possibleTransitions;

        $this->currentState = $possibleStates->getFirst();
    }

    public static function fromArrayOfPossibleTransitionsAndStates(array $possible): Machine
    {
        if (!isset($possible['transitions'])) {
            throw new \InvalidArgumentException('Please inform the possible transitions for the machine.');
        }

        if (!isset($possible['states'])) {
            throw new \InvalidArgumentException('Please inform the possible states for the machine.');
        }

        $possibleTransitions = new TransitionCollection();
        $possibleStates = new StateCollection();

        foreach ($possible['transitions'] as $transition) {
            $possibleTransitions->append(Transition::fromString($transition));
        }

        foreach ($possible['states'] as $state) {
            $possibleStates->append(State::fromString($state));
        }

        return new Machine($possibleStates, $possibleTransitions);
    }

    public function applyTransition(Transition $transition): State
    {
        if (!$this->possibleTransitions->has($transition)) {
            throw new \InvalidArgumentException('The transition sent is not possible on this machine.');
        }

        $this->currentState = $this->possibleStates->getNext($transition);

        return $this->currentState;
    }

    public function getPossibleTransitions(): TransitionCollection
    {
        return $this->possibleTransitions;
    }
}
