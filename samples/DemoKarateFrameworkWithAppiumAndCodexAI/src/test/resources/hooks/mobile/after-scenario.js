function fn(MobileActions, appPackage) {
  return function(){
    if (typeof driver !== 'undefined' && driver) {
      var screenshot = MobileActions.captureScreenshot(driver, karate.scenario.name);
      karate.embed(MobileActions.readBytes(screenshot), 'image/png');
      karate.log('Scenario screenshot:', screenshot);
      MobileActions.stopApp(driver, appPackage);
      MobileActions.stopSession(driver);
    }
  };
}
