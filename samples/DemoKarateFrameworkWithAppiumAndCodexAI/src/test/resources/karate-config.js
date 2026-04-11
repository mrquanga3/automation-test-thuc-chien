function fn() {
  var env = karate.env || 'android-emulator';
  var appium = read('classpath:config/' + env + '.json');

  return {
    env: env,
    appium: appium
  };
}
