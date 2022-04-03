<?php

namespace App\Application;


use App\Domain\Scooters;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\UuidInterface;

class CreateTrip
{

    private Scooters $scooters;

    /**
     * @param Scooters $scooters
     */
    public function __construct(Scooters $scooters)
    {
        $this->scooters = $scooters;
    }


    public function __invoke(UuidInterface $scooterId, int $x0, int $y0, string $serverUrl, string $token)
    {
        $statusCode = $this->request($scooterId, $x0, $y0, 'start_trip', $serverUrl, $token);
        Log::info ("Response: {$statusCode}");

        $x0 += 10;
        $statusCode = $this->request($scooterId, $x0, $y0, 'update_location', $serverUrl, $token);
        Log::info ("Response: {$statusCode}");

        $y0 += 10;
        $statusCode = $this->request($scooterId, $x0, $y0, 'end_trip', $serverUrl, $token);
        Log::info ("Response: {$statusCode}");
    }

    public function request(UuidInterface $scooterId, int $x0, int $y0, string $event, string $url, string $token): int
    {
        $requestBody = [
            'scooter_id' => $scooterId,
            'x' => $x0,
            'y' => $y0,
            'name' => $event
        ];

        $code = Http::withHeaders([
            'Content-Type' => 'application/json',
            'token' => $token,
        ])->post($url, $requestBody)->status();

        sleep(3);

        return $code;
    }
}
