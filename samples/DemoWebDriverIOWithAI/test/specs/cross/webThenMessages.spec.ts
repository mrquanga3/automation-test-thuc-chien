import { randomBytes } from 'node:crypto'

import { pingWebDriverSession } from '../../helpers/cross-web-session.js'
import { MessagesPage } from '../../pageobjects/mobile/MessagesPage.js'
import { DashboardPage } from '../../pageobjects/web/DashboardPage.js'
import { LoginPage } from '../../pageobjects/web/LoginPage.js'

function randomUsername(): string {
  return `wdio_${Date.now()}_${randomBytes(6).toString('hex')}`
}

describe('Cross — web login fail then Messages “Start chat”', () => {
  it('generates a user on web, login fails, then types same user in Messages', async () => {
    const mr = browser as unknown as WebdriverIO.MultiRemoteBrowser
    const web = mr.web
    const android = mr.android

    const randomUser = randomUsername()

    const loginPage = new LoginPage(web)
    const dashboardPage = new DashboardPage(web)

    await loginPage.open()
    await loginPage.login(randomUser, 'InvalidLoginPWD!9fz')
    await expect(await dashboardPage.isLoggedIn()).toBe(false)
    await expect(await loginPage.isDisplayed()).toBe(true)

    const messages = new MessagesPage(android)

    await pingWebDriverSession(web)
    await messages.waitForMainScreen()

    await pingWebDriverSession(web)
    await messages.tapStartChat()

    await pingWebDriverSession(web)
    await messages.typeRecipientOrSearch(randomUser)

    await pingWebDriverSession(web)
    await android.waitUntil(
      async () => {
        const text =
          (await messages.firstComposeEditText.getText().catch(() => '')) ||
          (await messages.firstComposeEditText.getAttribute('text').catch(() => '')) ||
          ''
        return text.includes(randomUser)
      },
      {
        timeout: 15000,
        timeoutMsg: 'Recipient/search field should contain the generated username',
      }
    )
  })
})
