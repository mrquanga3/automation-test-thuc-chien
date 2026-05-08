Feature: Common flow to type and verify message text

  Scenario: Type message text and verify it is visible in the editor
    * def textToType = __arg.textToType
    * eval MobileActions.typeFirstAvailable(driver, composeLocators.messageEditor, composeLocators.recipientEditor, composeLocators.recipientEditorFallback, composeLocators.messageEditorFallback, textToType)
    * def actualText = MobileActions.getTextFirstAvailable(driver, composeLocators.messageEditor, composeLocators.recipientEditor, composeLocators.recipientEditorFallback, composeLocators.messageEditorFallback)
    * print 'Captured editor text:', actualText
    * match actualText contains textToType
