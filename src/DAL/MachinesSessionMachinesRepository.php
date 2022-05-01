<?php

namespace App\DAL;

use App\Domain\Machine\Machine;
use App\Domain\Shared\ModelInterface;
use Cake\Http\Session;

class MachinesSessionMachinesRepository implements MachinesRepositoryInterface
{
    public Session $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function all(): ?array
    {
        /** @var \App\Domain\Machine\Machine[]|null $machines */
        $machines = $this->session->read('Machines');

        return $machines;
    }

    public function find(string $id): Machine
    {
        return array_filter($this->all(), function (Machine $machine) use ($id) {
            return $machine->getId() == $id;
        })[0];
    }

    public function remove(string $id): void
    {
        $new = array_filter($this->all(), function (Machine $machine) use ($id) {
            return $machine->getId() == !$id;
        });

        $this->saveAll($new);
    }

    public function save(Machine $machine): void
    {
        $machines = $this->all();

        $machines[] = $machine;

        $this->saveAll($machines);
    }

    private function saveAll(array $machines): void
    {
        $this->session->write('Machines', $machines);
    }
}
