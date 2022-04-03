<?php

namespace App\Domain;

use Ramsey\Uuid\UuidInterface;

class Event
{
    private UuidInterface $scooterId;
    private string $name;
    private int $x;
    private int $y;

    public function __construct(UuidInterface $scooterId, string $name, int $x, int $y)
    {
        $validEventNames = ['start_trip', 'update_location', 'end_trip'];

        if (!in_array($name, $validEventNames)) {
            throw new InvalidEventName();
        }

        $this->scooterId = $scooterId;
        $this->name = $name;
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @return UuidInterface
     */
    public function getScooterId(): UuidInterface
    {
        return $this->scooterId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }
}
