<?php

namespace App\Application;

use App\Domain\Scooter;
use App\Domain\Scooters;
use Illuminate\Http\Response;

class GetScooters
{
    private Scooters $scooters;

    /**
     * @param Scooters $scooters
     */
    public function __construct(Scooters $scooters)
    {
        $this->scooters = $scooters;
    }


    public function __invoke(int $x1, int $y1, int $x2, int $y2, bool $available) : array
    {
        return $this->scooters->filter($x1, $y1, $x2, $y2, $available);
    }
}
