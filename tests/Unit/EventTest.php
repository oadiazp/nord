<?php

namespace Tests\Unit;

use App\Domain\Event;
use App\Domain\InvalidEventName;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class EventTest extends TestCase
{
    public function testWrongEventName()
    {
        $this->expectException(InvalidEventName::class);

        $event = new Event(Uuid::uuid4(), 'wrong_name', 10, 10);
    }
}
