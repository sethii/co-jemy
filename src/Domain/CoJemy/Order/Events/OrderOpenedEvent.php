<?php

namespace Domain\CoJemy\Order\Events;

use Domain\CoJemy\Event;

class OrderOpenedEvent implements Event
{
    private $aggregateId;
    private $supplierId;

    public function __construct($aggregateId, $supplierId)
    {
        $this->aggregateId = $aggregateId;
        $this->supplierId = $supplierId;
    }

    public function getType()
    {
        return 'OrderOpenedEvent';
    }

    public function getParametersBag()
    {
        return [
            'aggregateId' => $this->aggregateId,
            'supplierId' => $this->supplierId,
        ];
    }
}
