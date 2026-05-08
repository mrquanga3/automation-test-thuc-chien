import dotenv from 'dotenv'

dotenv.config()

const androidUdid = process.env.ANDROID_UDID ?? 'emulator-5554'
const messagesPackage =
  process.env.MESSAGES_APP_PACKAGE ?? 'com.google.android.apps.messaging'
const messagesActivity =
  process.env.MESSAGES_APP_ACTIVITY ??
  'com.google.android.apps.messaging.ui.ConversationListActivity'

/**
 * Multiremote: Chrome (web) + Appium (Android). Android uses port 4723; web uses the default local driver.
 * @see https://webdriver.io/docs/multiremote
 */
export const config = {
  runner: 'local',
  specs: ['./test/specs/cross/**/*.ts'],
  maxInstances: 1,
  services: [
    [
      'appium',
      {
        args: {
          address: '127.0.0.1',
          port: 4723,
        },
        logPath: './logs',
      },
    ],
  ],
  capabilities: {
    web: {
      capabilities: {
        browserName: 'chrome',
        'goog:chromeOptions': {
          args: [
            ...(process.env.HEADLESS === '1'
              ? ['--headless=new', '--disable-gpu', '--window-size=1280,800']
              : []),
            // Reduce background throttling while Android has focus in multiremote runs
            '--disable-background-timer-throttling',
            '--disable-backgrounding-occluded-windows',
            '--disable-renderer-backgrounding',
          ],
        },
      },
    },
    android: {
      hostname: '127.0.0.1',
      port: 4723,
      path: '/',
      capabilities: {
        platformName: 'Android',
        'appium:automationName': 'UiAutomator2',
        'appium:deviceName': 'Android',
        'appium:udid': androidUdid,
        'appium:appPackage': messagesPackage,
        'appium:appActivity': messagesActivity,
        'appium:noReset': true,
        'appium:autoGrantPermissions': true,
        'appium:newCommandTimeout': 120,
      },
    },
  },
  logLevel: 'info',
  baseUrl: process.env.BASE_URL || 'http://103.245.237.118:8081',
  waitforTimeout: 20000,
  connectionRetryTimeout: 180000,
  connectionRetryCount: 2,
  framework: 'mocha',
  reporters: ['spec'],
  mochaOpts: {
    ui: 'bdd',
    timeout: 300000,
  },
} as unknown as WebdriverIO.Config
