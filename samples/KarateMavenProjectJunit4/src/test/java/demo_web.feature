Feature: Test home page
  Scenario: Test case check home page
    * def urlBase = 'http://127.0.0.1:18081/admin/'
    * configure driver = { type: 'chromedriver', executable: '/tmp/chromedriver-linux64/chromedriver', webDriverSession: { capabilities: { alwaysMatch: { 'goog:chromeOptions': { binary: '/opt/pw-browsers/chromium-1194/chrome-linux/chrome', args: ['--headless', '--no-sandbox', '--disable-dev-shm-usage', '--disable-gpu'] } } } } }
    * driver urlBase
    * input('#username', 'dummy')
    * input('#password', 'dummy')
    * click('#submit')
    * match text('#error') == 'Your username is invalid!'
