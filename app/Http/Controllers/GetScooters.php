<?php

namespace App\Http\Controllers;

use App\Infrastructure\DatabaseScooters;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Mockery\Exception;

class GetScooters extends Controller
{
    private DatabaseScooters $scooters;

    public function __construct(DatabaseScooters $scooters)
    {
        $this->scooters = $scooters;
    }

    public function __invoke(Request $request, int $x1, int $y1, int $x2, int $y2, bool $available)
    {
        try {
            return new Response(json_encode(
                array_map(
                    function ($scooter) {
                        return [
                            'id' => $scooter->id
                        ];
                    },
                    $this->scooters->filter($x1, $y1, $x2, $y2, $available)->all()
                )
            ), 200);
        } catch (Exception) {
            new Response(null, 400);
        }
    }
}
