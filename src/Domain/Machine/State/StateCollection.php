<?php

namespace App\Domain\Machine\State;

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
}
