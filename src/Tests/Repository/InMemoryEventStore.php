<?php

namespace Tests\Repository;

use Domain\CoJemy\EventStorePersister;
use Domain\CoJemy\Order;

class InMemoryEventStore implements EventStorePersister
{
    private $events = [];

    public function persist(array $events)
    {
        foreach($events as $event) {
            $this->events[] = $event;
        }
    }

    public function clear()
    {
        $this->events = [];
    }

    public function count()
    {
        $temp = [];
        foreach ($this->events as $event) {
            $temp[$event->getParametersBag()['aggregateId']] = null;
        }
        return count($temp);
    }

    public function getOrder()
    {
        return Order::recreate($this->events[0]->getParametersBag()['aggregateId'], $this->events);
    }
}
