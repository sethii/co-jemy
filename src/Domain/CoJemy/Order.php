<?php

namespace Domain\CoJemy;

use Domain\CoJemy\Order\Events\OrderOpenedEvent;

class Order
{
    private $id;
    private $latestEvents = [];
    private $supplierId;
    private $status;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public static function recreate($aggregateId, array $events)
    {
        $order = new self($aggregateId);
        foreach($events as $event) {
            $order->apply($event);
        }
        return $order;
    }

    public function open($supplierId)
    {
        $event = new OrderOpenedEvent($this->id, $supplierId);
        $this->latestEvents[] = $event;
        $this->apply($event);
    }

    private function apply(Event $event)
    {
        $methodName = 'apply'.$event->getType();
        $this->$methodName($event);
    }

    private function applyOrderOpenedEvent(OrderOpenedEvent $event)
    {
        $bag = $event->getParametersBag();
        $this->supplierId = $bag['supplierId'];
        $this->status = 'opened';
    }

    public function getLatestEvents()
    {
        $events = $this->latestEvents;
        $this->latestEvents = [];

        return $events;
    }

    public function getAggregateId()
    {
        return $this->id; 
    }

    public function getSupplierId()
    {
        return $this->supplierId; 
    }

    public function getStatus()
    {
        return $this->status;
    }
}
