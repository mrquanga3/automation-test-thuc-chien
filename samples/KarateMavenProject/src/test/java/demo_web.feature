Feature: Test admin login page
  Scenario: Login with invalid credentials shows error
    * def urlBase = 'https://opencart.abstracta.us/admin/'
    * configure driver = { type: 'chrome', addOptions: ['--no-sandbox', '--disable-dev-shm-usage'] }
    * driver urlBase
    * value('#input-username', '')
    * input('#input-username', 'dummy')
    * value('#input-password', '')
    * input('#input-password', 'dummy')
    * click('//button/i')
    * match text('.alert.alert-danger.alert-dismissible') contains 'No match for Username and/or Password.'
