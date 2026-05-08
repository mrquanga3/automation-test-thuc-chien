Feature: Android Messages smoke flow

  Background:
    * def MobileActions = Java.type('support.MobileActions')
    * def homeLocators = read('classpath:locators/messages/home.json')
    * def conversationListLocators = read('classpath:locators/messages/conversation-list.json')
    * def composeLocators = read('classpath:locators/messages/compose.json')
    * def appPackage = appium.capabilities['appium:appPackage']
    * def afterScenarioHook = read('classpath:hooks/mobile/after-scenario.js')
    * configure afterScenario = afterScenarioHook(MobileActions, appPackage)

  @android @smoke @messages
  Scenario: Open Messages, start chat and verify Hello World can be entered
    * call read('classpath:features/mobile/messages/common/setup_messages_app.feature')
    * call read('classpath:features/mobile/messages/common/open_start_chat.feature')
    * call read('classpath:features/mobile/messages/common/type_and_verify_message.feature') { textToType: 'Hello World' }
