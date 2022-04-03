<?php

namespace Tests\Feature;

use App\Domain\Event;
use App\Infrastructure\DatabaseScooters;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class GetScootersTest extends TestCase
{
    private DatabaseScooters $scooters;

    protected function setUp() : void
    {
        parent::setUp();

        DB::table('scooters')->truncate();
        $this->scooters = $this->app->make(DatabaseScooters::class);

        $this->scooters->create(new Event(Uuid::fromString('8431ae38-4f95-422a-9b5c-a37ffcaa3e2b'), 'start_trip', 0, 1));
        $this->scooters->create(new Event(Uuid::fromString('3a0b43ea-96da-4909-adf8-feb59dc0e6f3'), 'start_trip', 0, 9));
        $this->scooters->create(new Event(Uuid::fromString('794419da-521f-4c3b-9425-a20b48040714'), 'end_trip', 1, 9));
    }

    public function testGetScooters()
    {
        $response = $this->get('scooters/0/0/10/10/1', [
            'token' => getenv('AUTH_TOKEN')
        ]);

        $response->assertStatus(200);

        $scooterUuids = json_decode($response->getContent());
        $this->assertEquals(sizeof($scooterUuids), 1);
        $this->assertEquals('794419da-521f-4c3b-9425-a20b48040714', $scooterUuids[0]->id);
    }
}
