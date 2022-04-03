<?php

namespace App\Http\Controllers;

use App\Domain\Event;
use App\Infrastructure\DatabaseScooters;
use Illuminate\Http\Request;
use App\Application\ReceiveEvent as ReceiveEventUseCase;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;

class ReceiveEvent extends Controller
{
    private DatabaseScooters $databaseScooters;

    /**
     * @param DatabaseScooters $databaseScooters
     */
    public function __construct(DatabaseScooters $databaseScooters)
    {
        $this->databaseScooters = $databaseScooters;
    }

    public function __invoke(Request $request): Response
    {
        try {
            $receiveEvent = new ReceiveEventUseCase($this->databaseScooters);

            $event = new Event(
                Uuid::fromString($request->input('scooter_id')),
                $request->input('name'),
                $request->input('x'),
                $request->input('y')
            );

            $receiveEvent($event);

            return new Response([], 201);
        }

        catch (\Exception $e) {
            return new Response(null, 400);
        }
    }
}
