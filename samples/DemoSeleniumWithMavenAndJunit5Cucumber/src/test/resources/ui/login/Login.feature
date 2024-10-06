 # step (login folder) -> step definition (java) (login)
@ui @login
Feature: Test login
  Scenario: Test loading login page
    Given I opened chrome browser
    When I go to opencart login page
    Then I see login page

  @login_OK @regression @smoke
  Scenario: Test loading login page 2
    Given I opened chrome browser
    When I go to opencart login page
    Then I see login page

    @login_NOK
  Scenario: Test loading login page 3
    Given I opened chrome browser
    When I go to opencart login page
    Then I see login page