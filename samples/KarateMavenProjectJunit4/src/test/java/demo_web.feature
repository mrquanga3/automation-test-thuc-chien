Feature: Test home page
  Scenario: Test case check home page
    * def urlBase = 'https://practicetestautomation.com/practice-test-login/'
    * configure driver = { type: 'chrome', addOptions: ["--remote-allow-origins=*"] }
    * driver urlBase
    * input('#username', 'dummy')
    * input('#password', 'dummy')
    * click('#submit')
    * match text('#error') == 'Your username is invalid!'