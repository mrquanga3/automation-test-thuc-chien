/** Named multiremote instances from `wdio.cross.conf.ts`. */
declare namespace WebdriverIO {
  interface MultiRemoteBrowser {
    web: WebdriverIO.Browser
    android: WebdriverIO.Browser
  }
}
