<?php

namespace Tests\Feature;

use App\Application\CreateTrip;
use App\Domain\Scooters;
use App\Infrastructure\DatabaseScooters;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class CreateTripTest extends TestCase
{
    private Scooters $scooters;

    protected function setUp(): void
    {
        parent::setUp();

        DB::table('scooters')->truncate();
        $this->scooters = $this->app->make(DatabaseScooters::class);
    }


    public function testCreateATrip()
    {
        $scooterId = Uuid::uuid4();

        $x0 = random_int(0, 1000);
        $y0 = random_int(0, 1000);

        $createTrip = new CreateTrip($this->scooters);
        $createTrip($scooterId, $x0, $y0, 'http://localhost/events', false);

        $this->assertEquals($this->scooters->count(), 1);

        $scooter = $this->scooters->find($scooterId);
        $this->assertNotEquals($scooter->getX(), $x0);
        $this->assertNotEquals($scooter->getY(), $y0);
        $this->assertTrue($scooter->isAvailable());
    }
}
