# KarateMavenProject

A sample UI automation project using [Karate](https://github.com/karatelabs/karate) (v1.5.0) with JUnit 5 and Maven.

## Overview

This project demonstrates browser-based UI testing using Karate's built-in WebDriver support. It tests a login form by submitting invalid credentials and asserting the expected error message.

## Project Structure

```
src/test/java/
├── UiRunnerTest.java     # JUnit 5 test runner (starts/stops mock server)
├── demo_web.feature      # Karate feature file with UI test scenario
├── mock_server.py        # Python mock server (replaces blocked external demo site)
└── logback-test.xml      # Logging configuration
```

## Prerequisites

| Requirement | Version |
|-------------|---------|
| Java        | 17+     |
| Maven       | 3.6+    |
| Python      | 3.x     |
| ChromeDriver | Matching Chrome version |
| Chromium / Chrome | Any supported version |

## Running Tests

```bash
mvn test
```

## Driver Configuration

The feature file uses `type: 'chromedriver'` with explicit paths for ChromeDriver and the Chrome/Chromium binary. Update `demo_web.feature` to match your local environment:

```gherkin
* configure driver = {
    type: 'chromedriver',
    executable: '/path/to/chromedriver',
    webDriverSession: {
      capabilities: {
        alwaysMatch: {
          'goog:chromeOptions': {
            binary: '/path/to/chrome',
            args: ['--headless', '--no-sandbox', '--disable-dev-shm-usage', '--disable-gpu']
          }
        }
      }
    }
  }
```

### Finding Your Paths

```bash
# ChromeDriver
which chromedriver

# Chrome on Linux
which google-chrome || which chromium-browser

# Chrome on macOS
/Applications/Google\ Chrome.app/Contents/MacOS/Google\ Chrome --version
```

> **Note:** ChromeDriver version must match the Chrome/Chromium browser version. Download matching versions from [Chrome for Testing](https://googlechromelabs.github.io/chrome-for-testing/).

## Test Scenario

The test navigates to a login page, enters invalid credentials, and asserts the error message:

```gherkin
Feature: Test home page
  Scenario: Test case check home page
    * driver 'http://127.0.0.1:18080/admin/'
    * value('#input-username', '')
    * input('#input-username', 'dummy')
    * value('#input-password', '')
    * input('#input-password', 'dummy')
    * click('//button/i')
    * match text('.alert.alert-danger.alert-dismissible') == ' No match for Username and/or Password. '
```

The `mock_server.py` serves a local HTML login form (port 18080) that mimics the OpenCart admin interface, allowing tests to run without internet access.

## Issues Fixed

| Issue | Fix |
|-------|-----|
| `UiRunner` not picked up by Surefire | Renamed to `UiRunnerTest` to match Maven Surefire naming convention (`*Test`) |
| `driver config / start failed` | Corrected `type: 'chromedriver'` config — `executable` must be the **ChromeDriver** binary path, not Chrome itself. Chrome binary goes in `goog:chromeOptions.binary` |
| ChromeDriver version mismatch | Downloaded ChromeDriver matching the installed Chromium version |
| External demo site blocked | Added `mock_server.py` local server as a self-contained test target |
| Maven dependency download failures | Proxy authentication resolved by downloading missing JARs via curl |

## Dependencies

```xml
<dependency>
    <groupId>io.karatelabs</groupId>
    <artifactId>karate-junit5</artifactId>
    <version>1.5.0</version>
    <scope>test</scope>
</dependency>
```
