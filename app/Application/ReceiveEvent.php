<?php

namespace App\Application;

use App\Domain\Event;
use App\Domain\Scooters;

class ReceiveEvent
{
    private Scooters $scooters;

    /**
     * @param Scooters $scooters
     */
    public function __construct(Scooters $scooters)
    {
        $this->scooters = $scooters;
    }

    public function __invoke(Event $event)
    {
        $scooter = $this->scooters->find($event->getScooterId());

        if (!$scooter) {
            $this->scooters->create($event);
        }

        $this->scooters->update($event);

        return $this->scooters->find($event->getScooterId());
    }
}
