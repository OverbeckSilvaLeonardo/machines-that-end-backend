<?php

namespace App\Domain\Machine\Transition;

class TransitionCollection
{
    /**
     * @var \App\Domain\Machine\Transition\Transition[] $transitions
     */
    private array $transitions;

    public function append(Transition $new): void
    {
        foreach ($this->transitions as $transition) {
            if ($transition->getTransition() === $new->getTransition()) {
                return;
            }
        }

        array_push($this->transitions, $new);
    }

    public function getTransitions(): array
    {
        return $this->transitions;
    }
}
