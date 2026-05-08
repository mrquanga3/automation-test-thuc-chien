Feature: Common setup for Messages app

  Scenario: Start session and relaunch Messages from clean state
    * def driver = MobileActions.startAndroidSession(appium)
    * eval MobileActions.restartApp(driver, appPackage)
    * eval MobileActions.tapIfPresent(driver, homeLocators.permissionAllow)
