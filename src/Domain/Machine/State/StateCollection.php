<?php

namespace App\Domain\Machine\State;

use App\Domain\Machine\Machine;
use App\Domain\Machine\Transition\Transition;

class StateCollection
{
    /**
     * @var \App\Domain\Machine\State\State[] $states
     */
    private array $states;

    public function append(State $new): void
    {
        foreach ($this->states as $state) {
            if ($state->getState() === $new->getState()) {
                return;
            }
        }

        array_push($this->states, $new);
    }

    public function getStates(): array
    {
        return $this->states;
    }

    public function getFirst(): State
    {
        return $this->states[0];
    }

    public function getNext(Machine $machine, Transition $transition): State
    {
        if ($transition->isEight()) {
            return $this->find(State::AWAKE);
        }

        if ($transition->isTwelve()) {
            return $this->find(State::RESTING);

        }

        if ($transition->isThirteen()) {
            return $this->find(State::WORKING);

        }

        if ($transition->isEighteen()) {
            return $this->find(State::RESTING);

        }

        if ($transition->isTwentyTwo()) {
            return $this->find(State::SLEEPING);
        }

        throw new \RuntimeException('The machine does not have a corresponding state for the transition sent.');
    }

    private function find(string $wantedState): State
    {
        foreach ($this->states as $state) {
            if ($state->getState() == $wantedState) {
                return $state;
            }
        }
    }
}
