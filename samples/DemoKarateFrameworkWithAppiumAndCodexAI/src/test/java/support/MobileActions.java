package support;

import io.appium.java_client.MobileBy;
import io.appium.java_client.android.AndroidDriver;
import org.apache.commons.io.FileUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.openqa.selenium.By;
import org.openqa.selenium.NoSuchElementException;
import org.openqa.selenium.OutputType;
import org.openqa.selenium.TakesScreenshot;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

import java.io.File;
import java.io.IOException;
import java.util.List;
import java.util.Map;

public final class MobileActions {

    private static final Logger LOGGER = LoggerFactory.getLogger(MobileActions.class);
    private static final int DEFAULT_WAIT_SECONDS = 20;

    private MobileActions() {
    }

    public static AndroidDriver startAndroidSession(Map<String, Object> config) {
        LOGGER.info("Starting Android session");
        return MobileDriverFactory.createAndroidDriver(config);
    }

    public static void stopSession(AndroidDriver driver) {
        if (driver != null) {
            LOGGER.info("Stopping Android session");
            driver.quit();
        }
    }

    public static void restartApp(AndroidDriver driver, String appPackage) {
        LOGGER.info("Restarting app: {}", appPackage);
        driver.terminateApp(appPackage);
        sleep(1000);
        driver.activateApp(appPackage);
        sleep(2000);
        LOGGER.info("App restarted: {}", appPackage);
    }

    public static void stopApp(AndroidDriver driver, String appPackage) {
        LOGGER.info("Stopping app: {}", appPackage);
        driver.terminateApp(appPackage);
        sleep(1000);
        LOGGER.info("App stopped: {}", appPackage);
    }

    public static String captureScreenshot(AndroidDriver driver, String scenarioName) {
        String safeScenarioName = scenarioName == null ? "unknown-scenario" : scenarioName.replaceAll("[^a-zA-Z0-9-_]+", "_");
        String fileName = safeScenarioName + "_" + System.currentTimeMillis() + ".png";
        File targetDir = new File("target/screenshots");
        if (!targetDir.exists() && !targetDir.mkdirs()) {
            throw new IllegalStateException("Could not create screenshot directory: " + targetDir.getAbsolutePath());
        }

        File source = ((TakesScreenshot) driver).getScreenshotAs(OutputType.FILE);
        File destination = new File(targetDir, fileName);
        try {
            FileUtils.copyFile(source, destination);
            LOGGER.info("Screenshot saved: {}", destination.getAbsolutePath());
            return destination.getAbsolutePath();
        } catch (IOException e) {
            throw new IllegalStateException("Could not save screenshot to: " + destination.getAbsolutePath(), e);
        }
    }

    public static byte[] readBytes(String filePath) {
        try {
            return FileUtils.readFileToByteArray(new File(filePath));
        } catch (IOException e) {
            throw new IllegalStateException("Could not read screenshot bytes from: " + filePath, e);
        }
    }

    public static void tap(AndroidDriver driver, String locator) {
        LOGGER.info("Tap using locator: {}", locator);
        waitForVisible(driver, locator).click();
    }

    public static void tapFirstAvailable(AndroidDriver driver, List<String> locators) {
        LOGGER.info("Tap first available locator from list: {}", locators);
        waitForFirstVisible(driver, locators).click();
    }

    public static void tapEither(AndroidDriver driver, String firstLocator, String secondLocator) {
        tapFirstAvailable(driver, java.util.Arrays.asList(firstLocator, secondLocator));
    }

    public static boolean tapIfPresent(AndroidDriver driver, String locator) {
        try {
            LOGGER.info("Tap if present using locator: {}", locator);
            WebElement element = findNow(driver, locator);
            element.click();
            return true;
        } catch (NoSuchElementException ignored) {
            LOGGER.debug("Optional locator not present: {}", locator);
            return false;
        }
    }

    public static void type(AndroidDriver driver, String locator, String value) {
        LOGGER.info("Type into locator: {} | value: {}", locator, value);
        WebElement element = waitForVisible(driver, locator);
        element.clear();
        element.sendKeys(value);
    }

    public static void typeFirstAvailable(AndroidDriver driver, List<String> locators, String value) {
        LOGGER.info("Type into first available locator from list: {} | value: {}", locators, value);
        WebElement element = waitForFirstVisible(driver, locators);
        element.clear();
        element.sendKeys(value);
    }

    public static void typeFirstAvailable(AndroidDriver driver, String firstLocator, String secondLocator, String thirdLocator, String fourthLocator, String value) {
        typeFirstAvailable(driver, java.util.Arrays.asList(firstLocator, secondLocator, thirdLocator, fourthLocator), value);
    }

    public static String getText(AndroidDriver driver, String locator) {
        LOGGER.info("Get text from locator: {}", locator);
        return extractText(waitForVisible(driver, locator));
    }

    public static String getTextFirstAvailable(AndroidDriver driver, List<String> locators) {
        LOGGER.info("Get text from first available locator in list: {}", locators);
        return extractText(waitForFirstVisible(driver, locators));
    }

    public static String getTextFirstAvailable(AndroidDriver driver, String firstLocator, String secondLocator, String thirdLocator, String fourthLocator) {
        return getTextFirstAvailable(driver, java.util.Arrays.asList(firstLocator, secondLocator, thirdLocator, fourthLocator));
    }

    private static WebElement waitForVisible(AndroidDriver driver, String locator) {
        By by = toBy(locator);
        LOGGER.debug("Waiting for visible element: {}", locator);
        return new WebDriverWait(driver, DEFAULT_WAIT_SECONDS)
                .until(ExpectedConditions.visibilityOfElementLocated(by));
    }

    private static WebElement waitForFirstVisible(AndroidDriver driver, List<String> locators) {
        long endAt = System.currentTimeMillis() + (DEFAULT_WAIT_SECONDS * 1000L);
        NoSuchElementException lastError = null;
        while (System.currentTimeMillis() < endAt) {
            for (String locator : locators) {
                try {
                    LOGGER.debug("Trying locator: {}", locator);
                    return findNow(driver, locator);
                } catch (NoSuchElementException error) {
                    lastError = error;
                }
            }
            sleep(500);
        }
        throw lastError == null ? new NoSuchElementException("No locator matched: " + locators) : lastError;
    }

    private static WebElement findNow(AndroidDriver driver, String locator) {
        LOGGER.debug("Finding element now with locator: {}", locator);
        return driver.findElement(toBy(locator));
    }

    private static By toBy(String rawLocator) {
        if (rawLocator == null || rawLocator.trim().isEmpty()) {
            throw new IllegalArgumentException("Locator must not be blank");
        }

        int separatorIndex = rawLocator.indexOf('=');
        if (separatorIndex < 1) {
            throw new IllegalArgumentException("Locator must use strategy=value syntax. Actual: " + rawLocator);
        }

        String strategy = rawLocator.substring(0, separatorIndex).trim();
        String value = rawLocator.substring(separatorIndex + 1).trim();

        switch (strategy) {
            case "id":
                return By.id(value);
            case "xpath":
                return By.xpath(value);
            case "accessibilityId":
                return MobileBy.AccessibilityId(value);
            case "text":
                return By.xpath("//*[@text='" + value + "']");
            case "containsText":
                return By.xpath("//*[contains(@text,'" + value + "')]");
            default:
                throw new IllegalArgumentException("Unsupported locator strategy: " + strategy);
        }
    }

    private static String extractText(WebElement element) {
        String[] candidateAttributes = {"text", "content-desc", "value", "name"};
        for (String attribute : candidateAttributes) {
            String currentValue = element.getAttribute(attribute);
            if (currentValue != null && !currentValue.isBlank()) {
                return currentValue;
            }
        }

        String visibleText = element.getText();
        return visibleText == null ? "" : visibleText;
    }

    private static void sleep(long millis) {
        try {
            Thread.sleep(millis);
        } catch (InterruptedException e) {
            Thread.currentThread().interrupt();
            throw new IllegalStateException("Interrupted while waiting for element", e);
        }
    }
}
