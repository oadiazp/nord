<?php

namespace Test\Application;

use App\Application\ReceiveEvent;
use App\Domain\Event;
use App\Domain\InvalidEventName;
use App\Domain\Scooters;
use App\Infrastructure\InMemoryScooters;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class ReceiveEventTest extends TestCase
{
    private Scooters $scooters;

    public function setUp(): void
    {
        parent::setUp();

        $this->scooters = $this->app->make(InMemoryScooters::class);
    }

    public function testReceivedTripStartEvent()
    {
        $event = new Event(Uuid::uuid4(), 'start_trip', 10, 10);
        $receiveEvent = new ReceiveEvent($this->scooters);

        $scooter = $receiveEvent($event);

        $this->assertEquals($this->scooters->count(), 1);
        $this->assertEquals($scooter->getX(), 10);
        $this->assertEquals($scooter->getY(), 10);
        $this->assertFalse($scooter->isAvailable());
    }
}
