<?php

namespace App\Domain;

use Ramsey\Uuid\UuidInterface;

interface Scooters
{
    public function create(Event $event) : Scooter;

    public function find(UuidInterface $scooterId) : ?Scooter;

    public function update(Event $event) : Scooter;

    public function count() : int;

    public function filter(int $x1, int $y1, int $x2, int $y2, bool $available);
}
