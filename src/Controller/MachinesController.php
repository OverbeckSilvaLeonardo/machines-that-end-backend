<?php
declare(strict_types=1);

namespace App\Controller;

use App\Domain\Machine\Machine;
use App\Domain\Machine\Transition\Transition;
use App\Domain\Machine\Transition\TransitionCollection;
use Cake\Http\Response;
use Cake\Http\Session;

class MachinesController extends AppController
{
    private Session $session;

    public function __construct()
    {
        parent::__construct();
        $this->session = $this->getRequest()->getSession();
    }


    public function index(): Response
    {
        $machines = $this->session->read('Machines');

        return $this->getResponse()
            ->withType('application/json')
            ->withStatus(200)
            ->withStringBody(json_encode($machines));
    }

    public function create(): Response
    {
        $response = $this->getResponse()
            ->withType('application/json');

        try {
            $machine = Machine::fromArrayOfPossibleTransitionsAndStates($this->getRequest()->getData());

            $machines = $this->session->read('Machines');
            $machines[] = $machine;

            $this->session->write('Machines', $machines);

            return $response
                ->withStatus(200)
                ->withStringBody(json_encode(['success' => true, 'message' => 'The machine was added to the session.', 'machine' => $machine]));

        } catch (\InvalidArgumentException $e) {
            return $response
                ->withStatus(400)
                ->withStringBody(json_encode(['success' => false, 'message' => 'Invalid request. ' . $e->getMessage()]));

        } catch (\Throwable $e) {
            return $response
                ->withStatus(500)
                ->withStringBody(json_encode(['success' => false, 'message' => 'There was a problem processing the request. ' . $e->getMessage()]));
        }
    }

    public function transit(string $id): Response
    {
        /** @var \App\Domain\Machine\Machine $machine */
        $machine = array_filter($this->session->read('Machines'), function ($machine) use ($id) {
            return $machine->getId() == $id;
        })[0];

        $response = $this->getResponse()
            ->withType('application/json');

        if ($this->getRequest()->getData('state') && !$this->getRequest()->getData('transition')) {
            return $response
                ->withStatus(200)
                ->withStringBody(json_encode([
                    'success' => true,
                    'message' => 'The possible transitions were retrieved successfully.',
                    'possible_transitions' => $machine->getPossibleTransitions()
                ]));
        }

        $transition = $this->getRequest()->getData('transition');

         $machine->applyTransition(Transition::fromString($transition));

         return $response
             ->withStatus(200)
             ->withStringBody(json_encode([
                 'success' => true,
                 'message' => 'The state of the machine has been updated.',
                 'machine' => $machine
             ]));
    }

    public function remove(string $id): Response
    {

    }
}
