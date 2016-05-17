<?php

namespace spec\Domain\Order\Events;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Domain\Event;

class OrderOpenedEventSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('id123', 'shama');
    }

    function it_returns_the_event_type()
    {
        $this->getType()->shouldReturn('OrderOpenedEvent');
    }

    function it_is_an_event()
    {
        $this->shouldImplement(Event::class);
    }

    function it_returns_event_parameters()
    {
        $this->getParametersBag()->shouldBe([
            'aggregateId' => 'id123',
            'supplierId' => 'shama',
        ]);
    }
}
