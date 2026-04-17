Feature: Test home page
  Scenario: Test case check home page
    * def urlBase = 'http://127.0.0.1:18080/admin/'
    * configure driver = { type: 'chromedriver', executable: '/tmp/chromedriver_141/chromedriver-linux64/chromedriver', webDriverSession: { capabilities: { alwaysMatch: { 'goog:chromeOptions': { binary: '/opt/pw-browsers/chromium-1194/chrome-linux/chrome', args: ['--headless', '--no-sandbox', '--disable-dev-shm-usage', '--disable-gpu'] } } } } }
    * driver urlBase
    * value('#input-username', '')
    * input('#input-username', 'dummy')
    * value('#input-password', '')
    * input('#input-password', 'dummy')
    * click('//button/i')
    * match text('.alert.alert-danger.alert-dismissible') == ' No match for Username and/or Password. '
