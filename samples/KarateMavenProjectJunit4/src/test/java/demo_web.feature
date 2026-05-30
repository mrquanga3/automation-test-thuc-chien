Feature: Test login page
  Scenario: Login with invalid credentials shows error
    * def urlBase = 'https://practicetestautomation.com/practice-test-login/'
    * configure driver = { type: 'chrome', addOptions: ['--no-sandbox', '--disable-dev-shm-usage'] }
    * driver urlBase
    * input('#username', 'dummy')
    * input('#password', 'dummy')
    * click('#submit')
    * match text('#error') == 'Your username is invalid!'
