import dotenv from 'dotenv'

dotenv.config()

export const config: WebdriverIO.Config = {
  runner: 'local',
  specs: ['./test/specs/**/*.ts'],
  exclude: ['./test/specs/android/**/*.ts', './test/specs/cross/**/*.ts'],
  maxInstances: 1,
  capabilities: [
    {
      browserName: 'chrome',
      'goog:chromeOptions': {
        args: process.env.HEADLESS === '1' ? ['--headless=new', '--disable-gpu', '--window-size=1280,800'] : [],
      },
    },
  ],
  logLevel: 'info',
  baseUrl: process.env.BASE_URL || 'http://103.245.237.118:8081',
  waitforTimeout: 15000,
  connectionRetryTimeout: 120000,
  connectionRetryCount: 2,
  framework: 'mocha',
  reporters: ['spec'],
  mochaOpts: {
    ui: 'bdd',
    timeout: 120000,
  },
}
