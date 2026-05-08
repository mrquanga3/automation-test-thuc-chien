import * as actions from '../../helpers/actions.js'
import { MESSAGES_ACTIVITY, MESSAGES_PACKAGE } from '../../helpers/mobile-constants.js'

/**
 * Google Android Messages — selectors are best-effort across versions;
 * combine UI checks with {@link WebdriverIO.Browser#getCurrentPackage}.
 */
export class MessagesPage {
  constructor(private readonly driver: WebdriverIO.Browser) {}

  get searchOrConversationsEntry() {
    return this.driver.$('android=new UiSelector().descriptionContains("Search")')
  }

  /** FAB “Start chat” (English UI). */
  get startChatFab() {
    return this.driver.$('~Start chat')
  }

  get startChatByDesc() {
    return this.driver.$('android=new UiSelector().descriptionContains("Start chat")')
  }

  get startChatByText() {
    return this.driver.$('android=new UiSelector().textContains("Start chat")')
  }

  /** First text field on “new conversation” / recipient flow (To / search). */
  get firstComposeEditText() {
    return this.driver.$('android=new UiSelector().className("android.widget.EditText").instance(0)')
  }

  /** Ensures Messages is foreground (multiremote often leaves emulator on home launcher). */
  async bringToForeground(): Promise<void> {
    const pkg = await this.driver.getCurrentPackage().catch(() => '')
    if (pkg === MESSAGES_PACKAGE) {
      return
    }
    await this.driver.startActivity({
      appPackage: MESSAGES_PACKAGE,
      appActivity: MESSAGES_ACTIVITY,
    })
  }

  async waitForAppInForeground(): Promise<void> {
    await this.bringToForeground()
    await this.driver.waitUntil(
      async () => (await this.driver.getCurrentPackage()) === MESSAGES_PACKAGE,
      {
        timeout: 30000,
        timeoutMsg: `Expected package ${MESSAGES_PACKAGE} — check MESSAGES_APP_PACKAGE / install`,
      }
    )
  }

  async waitForMainScreen(): Promise<void> {
    await this.waitForAppInForeground()
    await this.driver.waitUntil(
      async () => {
        const search = await this.searchOrConversationsEntry.isDisplayed().catch(() => false)
        const fab = await this.startChatFab.isDisplayed().catch(() => false)
        const desc = await this.startChatByDesc.isDisplayed().catch(() => false)
        const txt = await this.startChatByText.isDisplayed().catch(() => false)
        return search || fab || desc || txt
      },
      {
        timeout: 25000,
        timeoutMsg:
          'Messages main screen: expected Search toolbar or Start chat (any known selector)',
      }
    )
  }

  async tapStartChat(): Promise<void> {
    const candidates = [this.startChatFab, this.startChatByDesc, this.startChatByText]
    let lastError: unknown
    for (const el of candidates) {
      try {
        await el.waitForDisplayed({ timeout: 12000 })
        await actions.click(el, { skipWaitForClickable: true })
        return
      } catch (err) {
        lastError = err
      }
    }
    throw lastError instanceof Error
      ? lastError
      : new Error('Could not find Start chat (FAB / description / text)')
  }

  /** After “Start chat”, type into the first visible recipient/search field. */
  async typeRecipientOrSearch(text: string): Promise<void> {
    await actions.waitForVisible(this.firstComposeEditText, { timeout: 20000 })
    await actions.enter(this.firstComposeEditText, text, { clearFirst: true })
  }
}
