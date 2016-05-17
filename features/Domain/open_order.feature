Feature: Open new order
  As a user I want to...
  So that I...

  Scenario:
    Given there are no order in the system
    When I open new order for supplier "shama"
    Then there should be "1" order with status "opened"
    And order should be placed for supplier "shama"