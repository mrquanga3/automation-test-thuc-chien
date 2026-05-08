# Demo Karate Framework With Appium

Karate OSS `1.3.1` + JUnit4 + Appium sample for Android emulator.

## What is included

- Maven test project wired for Karate JUnit4 runner.
- Appium Android driver factory and reusable mobile actions.
- A first smoke test for `Messages -> Start chat -> type Hello World`.
- A basic verification that reads the editor value back and asserts it contains `Hello World`.

## Run

Prerequisites:

- Java 11+
- Maven 3.8+
- Appium Server 2.x running on `http://127.0.0.1:4723`
- Android emulator running
- Google Messages installed on the emulator

Run all mobile tests:

```bash
mvn test
```

Run only the smoke test:

```bash
mvn test -Dkarate.options="--tags @smoke"
```

## Important notes

- `src/test/resources/config/android-emulator.json` contains sample capabilities. Adjust the `deviceName`, `platformVersion`, `appPackage`, and `appActivity` to match your emulator.
- `src/test/resources/locators/messages.json` contains starter locators for Google Messages. System app UIs differ between emulator images, so you may need to update these values after inspecting the actual screen.
- The current verification is intentionally practical: it types into the first visible editor after tapping `Start chat`, then reads the value back and checks that `Hello World` is present.
