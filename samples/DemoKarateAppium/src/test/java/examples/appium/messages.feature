Feature: Mo app Messages tren Android Emulator

  # ScreenshotHook.java tu dong chup sau moi step (ke ca khi fail)

  Scenario: Mo app Messages va verify thanh cong
    Given driver driverConfig
    And delay(5000)

    # retry() ap dung cho step ngay sau no: thu 10 lan, moi lan cach 2 giay
    And retry(10, 2000).waitFor('//*[@resource-id="com.google.android.apps.messaging:id/messages_title"]')
    And match driver.text('//*[@resource-id="com.google.android.apps.messaging:id/messages_title"]') == 'Messages'

    And retry(10, 2000).waitFor('//*[@resource-id="com.google.android.apps.messaging:id/start_chat_fab"]')
    And match driver.text('//*[@resource-id="com.google.android.apps.messaging:id/start_chat_fab"]') == 'Start chat'

    * print '=== App Messages da mo thanh cong! ==='
