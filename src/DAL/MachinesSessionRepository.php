<?php

namespace App\DAL;

use App\Domain\Machine\Machine;
use App\Domain\Shared\ModelInterface;
use Cake\Http\Session;

class MachinesSessionRepository implements RepositoryInterface
{
    public Session $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function all(): array
    {
        /** @var \App\Domain\Machine\Machine[] $machines */
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

    public function save(ModelInterface $model): void
    {
        if (!$model instanceof Machine::class) {
            throw new \InvalidArgumentException('Unable to save registry.');
        }

        $machines = $this->all();

        $machines[] = $model;

        $this->saveAll($machines);
    }

    private function saveAll(array $machines): void
    {
        $this->session->write('Machines', $machines);
    }
}
