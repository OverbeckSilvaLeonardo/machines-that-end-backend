<?php

namespace App\DAL;

use App\Domain\Machine\Machine;


interface MachinesRepositoryInterface
{
    public function all(): ?array;
    public function find(string $id): Machine;
    public function remove(string $id): void;
    public function save(Machine $machine): void;
}
