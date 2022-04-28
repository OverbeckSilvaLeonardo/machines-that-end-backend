<?php

namespace App\Domain\Machine\Transition;

class TransitionCollection
{
    /**
     * @var \App\Domain\Machine\Transition\Transition[] $transitions
     */
    private array $transitions = [];

    public function append(Transition $new): void
    {
        foreach ($this->transitions as $transition) {
            if ($transition->getTransition() === $new->getTransition()) {
                return;
            }
        }

        $this->transitions[] = $new;
    }

    public function getTransitions(): array
    {
        return $this->transitions;
    }

    public function has(Transition $transition): bool
    {
        foreach ($this->transitions as $possible) {
            if ($possible->getTransition() == $transition->getTransition()) {
                return true;
            }
        }

        return false;
    }
}
