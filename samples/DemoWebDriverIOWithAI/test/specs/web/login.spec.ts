import { DashboardPage } from '../../pageobjects/web/DashboardPage.js'
import { LoginPage } from '../../pageobjects/web/LoginPage.js'

const validUser = process.env.ADMIN_USER ?? 'admin'
const validPass = process.env.ADMIN_PASSWORD ?? 'admin'

describe('OpenCart admin — login', () => {
  let loginPage: LoginPage
  let dashboardPage: DashboardPage

  before(() => {
    loginPage = new LoginPage(browser)
    dashboardPage = new DashboardPage(browser)
  })

  beforeEach(async () => {
    await loginPage.open()
  })

  it('shows login form', async () => {
    await expect(loginPage.usernameInput).toBeDisplayed()
    await expect(loginPage.passwordInput).toBeDisplayed()
    await expect(loginPage.loginButton).toBeDisplayed()
  })

  it('logs in with valid credentials', async () => {
    await loginPage.login(validUser, validPass)
    await dashboardPage.waitForLoggedIn()
    await expect(await dashboardPage.isLoggedIn()).toBe(true)
  })

  it('rejects wrong password', async () => {
    await loginPage.login(validUser, 'definitely-wrong-password-xyz')
    await expect(await dashboardPage.isLoggedIn()).toBe(false)
    await expect(loginPage.usernameInput).toBeDisplayed()
  })

  it('rejects wrong username', async () => {
    await loginPage.login('not-a-real-admin-user', validPass)
    await expect(await dashboardPage.isLoggedIn()).toBe(false)
    await expect(loginPage.usernameInput).toBeDisplayed()
  })

  it('stays on login when both fields are empty', async () => {
    await loginPage.login('', '')
    await expect(await dashboardPage.isLoggedIn()).toBe(false)
    await expect(loginPage.usernameInput).toBeDisplayed()
  })

  it('does not reach dashboard with empty password', async () => {
    await loginPage.login(validUser, '')
    await expect(await dashboardPage.isLoggedIn()).toBe(false)
    await expect(loginPage.usernameInput).toBeDisplayed()
  })
})
