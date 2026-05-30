Feature: Test admin login page
  Scenario: Login with invalid credentials shows error
    * def urlBase = 'http://103.245.237.118:8081/opencart/administrator/'
    * configure driver = { type: 'chrome', addOptions: ['--no-sandbox', '--disable-dev-shm-usage'] }
    * driver urlBase
    * value('#input-username', '')
    * input('#input-username', 'dummy')
    * value('#input-password', '')
    * input('#input-password', 'dummy')
    * click('//button/i')
    # OpenCart 4 submits the login via AJAX, so wait for the error alert to appear
    * waitFor('.alert.alert-danger.alert-dismissible')
    * match text('.alert.alert-danger.alert-dismissible') == ' No match for Username and/or Password. '
