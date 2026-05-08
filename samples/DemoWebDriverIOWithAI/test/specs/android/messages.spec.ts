import { MESSAGES_PACKAGE } from '../../helpers/mobile-constants.js'
import { MessagesPage } from '../../pageobjects/mobile/MessagesPage.js'

describe('Android — Messages app', () => {
  let messages: MessagesPage

  before(() => {
    messages = new MessagesPage(browser)
  })

  it('opens with expected package', async () => {
    await messages.waitForAppInForeground()
    await expect(await browser.getCurrentPackage()).toBe(MESSAGES_PACKAGE)
  })

  it('shows main conversation UI', async () => {
    await messages.waitForMainScreen()
    const onSearch = await messages.searchOrConversationsEntry.isDisplayed().catch(() => false)
    const onFab = await messages.startChatFab.isDisplayed().catch(() => false)
    await expect(onSearch || onFab).toBe(true)
  })
})
