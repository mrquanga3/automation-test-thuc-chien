import dotenv from 'dotenv'

dotenv.config()

/** `adb devices` serial, e.g. emulator-5554 (first emulator) */
const androidUdid = process.env.ANDROID_UDID ?? 'emulator-5554'

const messagesPackage =
  process.env.MESSAGES_APP_PACKAGE ?? 'com.google.android.apps.messaging'

/** Main launcher activity; override if your build differs (see .env.example). */
const messagesActivity =
  process.env.MESSAGES_APP_ACTIVITY ??
  'com.google.android.apps.messaging.ui.ConversationListActivity'

export const config: WebdriverIO.Config = {
  runner: 'local',
  hostname: '127.0.0.1',
  port: 4723,
  path: '/',
  specs: ['./test/specs/android/**/*.ts'],
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
  capabilities: [
    {
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
  ],
  logLevel: 'info',
  waitforTimeout: 20000,
  connectionRetryTimeout: 180000,
  connectionRetryCount: 2,
  framework: 'mocha',
  reporters: ['spec'],
  mochaOpts: {
    ui: 'bdd',
    timeout: 180000,
  },
}
