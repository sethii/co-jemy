<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Infrastructure\CoJemy\Order\Handlers\OpenOrderHandler;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\Locator\InMemoryLocator;
use League\Tactician\Handler\MethodNameInflector\HandleClassNameInflector;
use Tests\Repository\InMemoryEventStore;
use Infrastructure\CoJemy\Order\Commands\OpenOrderCommand;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    private $inMemoryEventStore;
    private $commandBus;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->inMemoryEventStore = new InMemoryEventStore();
        $locator = new InMemoryLocator();
        $locator->addHandler(new OpenOrderHandler($this->inMemoryEventStore), OpenOrderCommand::class);
        $handlerMiddleware = new \League\Tactician\Handler\CommandHandlerMiddleware(
            new ClassNameExtractor(),
            $locator,
            new HandleClassNameInflector()
        );
        $this->commandBus = new \League\Tactician\CommandBus([$handlerMiddleware]);
    }

    /**
     * @Given there are no order in the system
     */
    public function thereAreNoOrderInTheSystem()
    {
        $this->inMemoryEventStore->clear();
    }

    /**
     * @When I open new order for supplier :arg1
     */
    public function iOpenNewOrderForSupplier($supplierId)
    {
        $this->commandBus->handle(new OpenOrderCommand($supplierId));
    }

    /**
     * @Then there should be :arg1 order with status :arg2
     */
    public function thereShouldBeOrderWithStatus($arg1, $arg2)
    {
        if ($this->inMemoryEventStore->count() != $arg1) {
            throw new RuntimeException('Bad count of orders');
        }
        if ($this->inMemoryEventStore->getOrder()->getStatus() != $arg2) {
            throw new RuntimeException('Bad status');
        }
    }

    /**
     * @Then order should be placed for supplier :arg1
     */
    public function orderShouldBePlacedForSupplier($arg1)
    {
        if ($this->inMemoryEventStore->getOrder()->getSupplierId() != $arg1) {
            throw new RuntimeException('Bad supplier');
        }
    }
}
