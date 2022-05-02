<?php

namespace App\Domain\Shared;

class BaseModel
{
    protected string $id;

    public function __construct()
    {
        $this->id = uniqid('machine');
    }

    public function getId(): string
    {
        return $this->id;
    }
}
