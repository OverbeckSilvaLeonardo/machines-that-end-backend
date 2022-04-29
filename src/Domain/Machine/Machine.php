<?php

namespace App\Domain\Machine;


use App\Domain\Machine\State\State;
use App\Domain\Machine\State\StateCollection;
use App\Domain\Machine\Transition\Transition;
use App\Domain\Machine\Transition\TransitionCollection;
use App\Domain\Shared\BaseModel;
use App\Domain\Shared\ModelInterface;

class Machine extends BaseModel implements ModelInterface
{
    private State $currentState;
    private StateCollection $possibleStates;
    private TransitionCollection $possibleTransitions;

    private function __construct(StateCollection $possibleStates, TransitionCollection $possibleTransitions)
    {
        $this->possibleStates = $possibleStates;
        $this->possibleTransitions = $possibleTransitions;

        $this->currentState = $possibleStates->getFirst();

        parent::__construct();
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
