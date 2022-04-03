<?php

namespace App\Infrastructure;

use App\Domain\Event;
use App\Domain\Scooter;
use App\Domain\Scooters;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class DatabaseScooters implements Scooters
{

    public function create(Event $event): Scooter
    {
        DB::table('scooters')->insert([
            'id' => Uuid::fromString($event->getScooterId()),
            'x' => $event->getX(),
            'y' => $event->getY(),
            'available' => $event->getName() == 'end_trip'
        ]);

        return $this->find($event->getScooterId());
    }

    public function find(UuidInterface $scooterId): ?Scooter
    {
        $object = DB::table('scooters')
            ->where('id', $scooterId)
            ->first();

        if (null === $object) {
            return null;
        }

        return new Scooter(
            Uuid::fromString($object->id),
            $object->x,
            $object->y,
            $object->available
        );
    }

    public function update(Event $event): Scooter
    {
        DB::table('scooters')
            ->where('id', $event->getScooterId())
            ->update([
                'x' => $event->getX(),
                'y' => $event->getY(),
                'available' => $event->getName() == 'end_trip'
            ]);

        return $this->find($event->getScooterId());
    }

    public function count(): int
    {
        return DB::table('scooters')->count();
    }

    public function filter(int $x1, int $y1, int $x2, int $y2, bool $available)
    {
        return DB::table('scooters')
            ->whereBetween('x', [$x1, $x2])
            ->whereBetween('y', [$y1, $y2])
            ->where('available', $available)
            ->get();

    }
}
