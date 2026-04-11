/**
 * Lightweight WebDriver command on the **web** instance so Chrome stays “warm” during
 * long Android steps. Call **only between** native actions — do **not** run in parallel
 * with Appium (multiremote can interleave responses and break element lookups).
 */
export async function pingWebDriverSession(web: WebdriverIO.Browser): Promise<void> {
  try {
    await web.getUrl()
  } catch {
    /* ignore — session may already be ending */
  }
}
