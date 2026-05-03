import * as actions from '../../helpers/actions.js'
import { ADMIN_LOGIN_PATH } from '../../helpers/web/constants.js'

/**
 * OpenCart admin login (typical OC 3.x selectors; falls back to name attributes).
 * Pass a driver (`browser` in web-only runs, or `browser.getInstance('web')` in multiremote).
 */
export class LoginPage {
  constructor(private readonly driver: WebdriverIO.Browser) {}

  get usernameInput() {
    return this.driver.$('input[name="username"], #input-username')
  }

  get passwordInput() {
    return this.driver.$('input[name="password"], #input-password')
  }

  get loginButton() {
    return this.driver.$('#button-login, button[type="submit"]')
  }

  get alertDanger() {
    return this.driver.$('.alert-danger')
  }

  async open(): Promise<void> {
    await this.driver.url(ADMIN_LOGIN_PATH)
    await actions.waitForVisible(this.usernameInput, {
      timeoutMsg: 'Login page username field not found',
    })
  }

  async login(username: string, password: string): Promise<void> {
    await actions.enter(this.usernameInput, username)
    await actions.enter(this.passwordInput, password)
    await actions.click(this.loginButton)
  }

  async isDisplayed(): Promise<boolean> {
    return actions.isDisplayed(this.usernameInput)
  }

  async hasErrorAlert(): Promise<boolean> {
    return actions.isDisplayed(this.alertDanger)
  }

  async getErrorText(): Promise<string> {
    if (await this.hasErrorAlert()) {
      return actions.getText(this.alertDanger)
    }
    return ''
  }
}
