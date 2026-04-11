Feature: Common flow to open start chat screen

  Scenario: Tap Start chat from conversation list or home screen
    * eval MobileActions.tapEither(driver, conversationListLocators.startChat, conversationListLocators.startChatFallback)
