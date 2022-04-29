<?php
declare(strict_types=1);

namespace App\Controller;

use App\DAL\MachinesSessionRepository;
use App\DAL\RepositoryInterface;
use App\Domain\Machine\Machine;
use App\Domain\Machine\Transition\Transition;
use Cake\Http\Response;
use Cake\Http\Session;

class MachinesController extends AppController
{
    private RepositoryInterface $repository;

    public function initialize(): void
    {
        parent::initialize();
        $this->repository = new MachinesSessionRepository($this->getRequest()->getSession());
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

            $this->repository->save($machine);

            return $response
                ->withStatus(200)
                ->withStringBody(json_encode(['success' => true, 'message' => 'The machine was added to the session.', 'machine' => $machine->toArray()]));

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
        $machine = $this->repository->find($id);

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
        $this->repository->remove($id);
    }
}
