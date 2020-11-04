<?php

namespace App\Models;

class Currency
{
    private int $id;
    private string $name;
    private float $rate;
    private string $updatedAt;

    public function __construct(int $id, string $name, float $rate, string $updatedAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->rate = $rate;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRate():float
    {
        return $this->rate;
    }

    public function getUpdateDate(): string
    {
        return $this->updatedAt;
    }

}