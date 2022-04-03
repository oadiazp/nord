<?php

namespace App\Console\Commands;

use App\Infrastructure\DatabaseScooters;
use Illuminate\Console\Command;
use App\Application\CreateTrip as CreateTripUseCase;
use Ramsey\Uuid\Uuid;

class CreateTrip extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nord:create_trip {scooter_id} {url} {token=false}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a client that makes a trip';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(DatabaseScooters $scooters)
    {

        $scooterId = $this->argument('scooter_id');
        $token = $this->argument('token');
        $url = $this->argument('url');
        $createTrip = new CreateTripUseCase($scooters);

        while (true) {
            $x0 = random_int(0, 1000);
            $y0 = random_int(0, 1000);

            $createTrip(Uuid::fromString($scooterId), $x0, $y0, $url, $token);
            sleep(2);
        }

        return 0;
    }
}
