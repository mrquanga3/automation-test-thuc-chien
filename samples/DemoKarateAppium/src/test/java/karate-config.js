function fn() {
  var config = {};

  // Appium driver config cho Android emulator
  // Retry config: waitFor() se thu lai 10 lan, moi lan cach 2 giay (tong ~20 giay)
  config.retry = { count: 10, interval: 2000 };

  config.driverConfig = {
    type: 'android',                                          // Loai driver: android
    webDriverUrl: 'http://127.0.0.1:4723',                    // URL cua Appium server
    webDriverSession: {
      capabilities: {
        alwaysMatch: {
          'appium:platformName': 'Android',                   // Platform: Android
          'appium:deviceName': 'emulator-5554',               // Ten emulator (lay tu: adb devices)
          'appium:automationName': 'UiAutomator2',            // Driver automation cho Android
          'appium:appPackage': 'com.google.android.apps.messaging',          // Package app (lay tu: adb shell pm list packages)
          'appium:appActivity': '.ui.ConversationListActivity',             // Activity chinh (lay tu: adb shell cmd package resolve-activity)
          'appium:noReset': true,                             // Khong reset app state giua cac test
          'appium:newCommandTimeout': 60,                     // Timeout cho moi lenh (giay)
          'appium:appWaitForLaunch': true,                    // Cho app launch xong moi tiep tuc
          'appium:appWaitDuration': 30000                     // Cho toi da 30 giay de app khoi dong
        }
      }
    }
  };

  return config;
}
