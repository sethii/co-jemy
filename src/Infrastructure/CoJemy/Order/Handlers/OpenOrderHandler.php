<?php

namespace Infrastructure\CoJemy\Order\Handlers;

use Domain\CoJemy\EventStorePersister;
use Domain\CoJemy\Order;
use Infrastructure\CoJemy\Order\Commands\OpenOrderCommand;

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
