import type { WaitForOptions } from 'webdriverio'

/**
 * Shared UI actions: pass a CSS/XPath string or an element from `$()`.
 * Keeps page objects free of repeated `waitFor*` / `click` / `setValue` boilerplate.
 */

export type Locator = string | ReturnType<typeof $>

function resolve(target: Locator): ReturnType<typeof $> {
  return typeof target === 'string' ? $(target) : target
}

export async function waitForVisible(target: Locator, options?: WaitForOptions): Promise<void> {
  await resolve(target).waitForDisplayed(options)
}

export async function click(
  target: Locator,
  options?: { skipWaitForClickable?: boolean }
): Promise<void> {
  const element = resolve(target)
  if (options?.skipWaitForClickable) {
    await element.waitForDisplayed()
  } else {
    try {
      await element.waitForClickable()
    } catch {
      // Native Android/iOS (Appium) — waitForClickable is not supported
      await element.waitForDisplayed()
    }
  }
  await element.click()
}

export async function enter(
  target: Locator,
  value: string,
  options?: { clearFirst?: boolean }
): Promise<void> {
  const element = resolve(target)
  await element.waitForDisplayed()
  if (options?.clearFirst) {
    await element.clearValue()
  }
  await element.setValue(value)
}

export async function getText(target: Locator): Promise<string> {
  return resolve(target).getText()
}

export async function isDisplayed(target: Locator): Promise<boolean> {
  return resolve(target).isDisplayed().catch(() => false)
}
