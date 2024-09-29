Feature: Test home page
  Scenario: Test case check home page
    * def urlBase = 'https://demo.opencart.com/admin/'
    * def driver = { type: 'chrome', showDriverLog: true }
    * driver urlBase
    * value('#input-username', '')
    * input('#input-username', 'dummy')
    * value('#input-password', '')
    * input('#input-password', 'dummy')
    * click('//button/i')
    * match text('.alert.alert-danger.alert-dismissible') == ' No match for Username and/or Password. '