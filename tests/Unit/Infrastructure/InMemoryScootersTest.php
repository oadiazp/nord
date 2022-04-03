<?php

namespace App\Test\Infrastructure;

use App\Domain\Event;
use App\Infrastructure\InMemoryScooters;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class InMemoryScootersTest extends TestCase
{
    private InMemoryScooters $inMemoryScooters;

    protected function setUp() : void
    {
        parent::setUp();

        $this->inMemoryScooters = new InMemoryScooters();
    }


    public function testCreate()
    {
        $generatedScooterId = Uuid::uuid4();

        $this->inMemoryScooters->create(
            new Event($generatedScooterId, 'start_trip', 10, 10)
        );


        $foundScooter = $this->inMemoryScooters->find($generatedScooterId);
        $this->assertEquals($this->inMemoryScooters->count(), 1);
        $this->assertEquals($foundScooter->getX(), 10);
        $this->assertEquals($foundScooter->getY(), 10);
        $this->assertFalse($foundScooter->isAvailable());
    }

    public function testUpdate()
    {
        $generatedScooterId = Uuid::uuid4();

        $this->inMemoryScooters->create(
            new Event($generatedScooterId, 'start_trip', 10, 10)
        );

        $this->inMemoryScooters->update(new Event($generatedScooterId, 'update_location', 10, 100));

        $foundScooter = $this->inMemoryScooters->find($generatedScooterId);

        $this->assertEquals($foundScooter->getX(), 10);
        $this->assertEquals($foundScooter->getY(), 100);
        $this->assertFalse($foundScooter->isAvailable());
    }
}
