<?php

namespace App\Infrastructure;

use App\Domain\Event;
use App\Domain\Scooter;
use App\Domain\Scooters;
use Ramsey\Uuid\UuidInterface;

class InMemoryScooters implements Scooters
{
    /** @var Scooter[] */
    private array $scooters;

    public function __construct()
    {
        $this->scooters = [];
    }


    public function create(Event $event): Scooter
    {
        $newScooter = new Scooter(
            $event->getScooterId(),
            $event->getX(),
            $event->getY(),
            $event->getName() == 'end_trip'
        );

        $this->scooters[] = $newScooter;

        return $newScooter;
    }

    public function find(UuidInterface $scooterId): ?Scooter
    {
        $filteredScooters = array_filter($this->scooters, function (Scooter $scooter) use ($scooterId) {
            return $scooter->getId() == $scooterId;
        });

        if ($filteredScooters) {
            return $filteredScooters[0];
        }

        return null;
    }

    public function update(Event $event): Scooter
    {
        $scooter = $this->find($event->getScooterId());

        $scooter->setX($event->getX());
        $scooter->setY($event->getY());
        $scooter->setAvailable($event->getName() == 'end_trip');

        return $scooter;
    }

    public function count(): int
    {
        return sizeof($this->scooters);
    }

    public function filter(int $x1, int $y1, int $x2, int $y2, bool $available)
    {
        return array_filter($this->scooters, function (Scooter $scooter) use ($x1, $y1, $x2, $y2, $available) {
            return
                ($scooter->isAvailable() == $available) &&
                ($scooter->getX() >= $x1) &&
                ($scooter->getX() <= $x2) &&
                ($scooter->getY() >= $y1) &&
                ($scooter->getY() <= $y2);
        });
    }
}
