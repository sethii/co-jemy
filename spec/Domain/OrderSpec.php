<?php

namespace spec\Domain;

use Domain\Order\Events\OrderOpenedEvent;
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
}
