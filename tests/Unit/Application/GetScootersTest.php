<?php

namespace Test\Application;

use App\Application\GetScooters;
use App\Domain\Event;
use App\Infrastructure\InMemoryScooters;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class GetScootersTest extends TestCase
{
    private InMemoryScooters $scooters;

    protected function setUp() : void
    {
        parent::setUp();

        $this->scooters = $this->app->make(InMemoryScooters::class);

        $this->scooters->create(new Event(Uuid::fromString('8431ae38-4f95-422a-9b5c-a37ffcaa3e2b'), 'start_trip', 0, 1));
        $this->scooters->create(new Event(Uuid::fromString('3a0b43ea-96da-4909-adf8-feb59dc0e6f3'), 'start_trip', 0, 9));
        $this->scooters->create(new Event(Uuid::fromString('794419da-521f-4c3b-9425-a20b48040714'), 'end_trip', 1, 9));
    }

    public function testGetScooters()
    {
        $getScooters = new GetScooters($this->scooters);

        $scooters = $getScooters(0, 0, 11, 11, true);

        $this->assertEquals(sizeof($scooters), 1);
    }
}
