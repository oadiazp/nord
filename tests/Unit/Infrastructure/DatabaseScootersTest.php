<?php

namespace App\Test\Infrastructure;

use App\Domain\Event;
use App\Infrastructure\DatabaseScooters;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class DatabaseScootersTest extends TestCase
{
    private DatabaseScooters $databaseScooters;

    protected function setUp() : void
    {
        parent::setUp();

        DB::table('scooters')->truncate();
        $this->databaseScooters = $this->app->make(DatabaseScooters::class);
    }

    public function testCreate()
    {
        $generatedScooterId = Uuid::uuid4();

        $this->databaseScooters->create(
            new Event($generatedScooterId, 'start_trip', 10, 10)
        );


        $foundScooter = $this->databaseScooters->find($generatedScooterId);
        $this->assertEquals($this->databaseScooters->count(), 1);
        $this->assertEquals($foundScooter->getX(), 10);
        $this->assertEquals($foundScooter->getY(), 10);
        $this->assertFalse($foundScooter->isAvailable());
    }

    public function testUpdate()
    {
        $generatedScooterId = Uuid::uuid4();

        $this->databaseScooters->create(
            new Event($generatedScooterId, 'start_trip', 10, 10)
        );

        $this->databaseScooters->update(new Event($generatedScooterId, 'update_location', 10, 100));

        $foundScooter = $this->databaseScooters->find($generatedScooterId);

        $this->assertEquals($foundScooter->getX(), 10);
        $this->assertEquals($foundScooter->getY(), 100);
        $this->assertFalse($foundScooter->isAvailable());
    }
}
