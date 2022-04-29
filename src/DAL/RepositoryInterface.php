<?php

namespace App\DAL;

use App\Domain\Shared\BaseModel;
use App\Domain\Shared\ModelInterface;

interface RepositoryInterface
{
    public function all(): array;
    public function find(string $id): ModelInterface;
    public function remove(string $id): void;
    public function save(ModelInterface $model): void;
}
