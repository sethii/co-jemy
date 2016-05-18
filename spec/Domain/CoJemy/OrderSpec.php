<?php

namespace spec\Domain\CoJemy;

use Domain\CoJemy\Order\Events\OrderOpenedEvent;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OrderSpec extends ObjectBehavior
{
    function it_opens_an_order()
    {
        $this->beConstructedWith('id123');
        $this->open('shama');
        $events = $this->getLatestEvents();
        $events->shouldHaveCount(1);
        $events[0]->shouldBeAnInstanceOf(OrderOpenedEvent::class);
        $this->getAggregateId()->shouldBe('id123');
        $this->getSupplierId()->shouldBe('shama');
        $this->getStatus()->shouldBe('opened');
    }

    function it_should_recreate_order_from_events()
    {
        $this->beConstructedThrough('recreate', ['id123', [
            new OrderOpenedEvent('id123', 'shama'),
        ]]);
        $this->getAggregateId()->shouldBe('id123');
        $this->getSupplierId()->shouldBe('shama');
        $this->getStatus()->shouldBe('opened');
    }
}
