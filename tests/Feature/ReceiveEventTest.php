<?php

namespace Tests\Feature;


use App\Infrastructure\DatabaseScooters;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class ReceiveEventTest extends TestCase
{
    private DatabaseScooters $databaseScooters;

    protected function setUp() : void
    {
        parent::setUp();
        DB::table('scooters')->truncate();
        $this->databaseScooters = $this->app->make(DatabaseScooters::class);
    }

    public function testReceiveEventFromANewScooter()
    {
        $requestBody = [
            'scooter_id' => '8514bac2-8750-464e-a0ff-095c3358ff0b',
            'x' => 10,
            'y' => 10,
            'name' => 'trip_start'
        ];

        $response = $this->postJson('/events', $requestBody, [
            'Content-Type' => 'application/json',
            'token' => getenv('AUTH_TOKEN'),
        ]);

        $response->assertStatus(201);
        $this->assertEquals($this->databaseScooters->count(), 1);

        $scooter = $this->databaseScooters->find(Uuid::fromString('8514bac2-8750-464e-a0ff-095c3358ff0b'));

        $this->assertEquals($scooter->getX(), 10);
        $this->assertEquals($scooter->getY(), 10);
        $this->assertFalse($scooter->isAvailable());
    }

    public function testScooterIsAvailableAfterTripEnds()
    {
        $requestBody = [
            'scooter_id' => '8514bac2-8750-464e-a0ff-095c3358ff0b',
            'x' => 10,
            'y' => 10,
            'name' => 'end_trip'
        ];

        $response = $this->postJson('/events', $requestBody, [
            'Content-Type' => 'application/json',
            'token' => getenv('AUTH_TOKEN'),
        ]);

        $response->assertStatus(201);

        $scooter = $this->databaseScooters->find(Uuid::fromString('8514bac2-8750-464e-a0ff-095c3358ff0b'));
        $this->assertTrue($scooter->isAvailable());
    }
}
