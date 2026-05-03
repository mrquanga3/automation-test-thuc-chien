import * as actions from '../../helpers/actions.js'

/**
 * Post-login admin area — minimal anchors to assert successful authentication.
 */
export class DashboardPage {
  constructor(private readonly driver: WebdriverIO.Browser) {}

  get logoutLink() {
    return this.driver.$('a*=Logout')
  }

  get navigation() {
    return this.driver.$('#navigation')
  }

  async waitForLoggedIn(): Promise<void> {
    await this.driver.waitUntil(
      async () => {
        const nav = await actions.isDisplayed(this.navigation)
        const logout = await actions.isDisplayed(this.logoutLink)
        return nav || logout
      },
      {
        timeout: 20000,
        timeoutMsg: 'Expected dashboard (navigation or Logout) after login',
      }
    )
  }

  async isLoggedIn(): Promise<boolean> {
    const nav = await actions.isDisplayed(this.navigation)
    const logout = await actions.isDisplayed(this.logoutLink)
    return nav || logout
  }
}
