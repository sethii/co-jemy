<?php

namespace Infrastructure\Order\Handlers;

use Domain\EventStorePersister;
use Domain\Order;
use Infrastructure\Order\Commands\OpenOrderCommand;

class OpenOrderHandler
{
    private $eventStorePersister;

    public function __construct(EventStorePersister $eventStorePersister)
    {
        $this->eventStorePersister = $eventStorePersister;
    }

    public function handleOpenOrderCommand(OpenOrderCommand $command)
    {
        $order = new Order(uniqid());
        $order->open($command->getSupplierId());
        $this->eventStorePersister->persist($order->getLatestEvents());
    }
}
