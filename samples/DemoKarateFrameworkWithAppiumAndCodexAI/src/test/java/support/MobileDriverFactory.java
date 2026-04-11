package support;

import io.appium.java_client.android.AndroidDriver;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.openqa.selenium.remote.DesiredCapabilities;

import java.net.MalformedURLException;
import java.net.URL;
import java.util.Map;
import java.util.concurrent.TimeUnit;

public final class MobileDriverFactory {

    private static final Logger LOGGER = LoggerFactory.getLogger(MobileDriverFactory.class);

    private MobileDriverFactory() {
    }

    public static AndroidDriver createAndroidDriver(Map<String, Object> config) {
        try {
            String serverUrl = asString(config.getOrDefault("serverUrl", "http://127.0.0.1:4723"));
            DesiredCapabilities capabilities = new DesiredCapabilities();

            Object capabilitiesObject = config.get("capabilities");
            if (!(capabilitiesObject instanceof Map)) {
                throw new IllegalArgumentException("Missing capabilities map in appium config");
            }

            @SuppressWarnings("unchecked")
            Map<String, Object> rawCapabilities = (Map<String, Object>) capabilitiesObject;
            applyCapabilities(capabilities, rawCapabilities);

            LOGGER.info("Creating Android session at {}", serverUrl);
            LOGGER.debug("Resolved capabilities: {}", rawCapabilities);

            AndroidDriver driver = new AndroidDriver(new URL(serverUrl), capabilities);
            long implicitWaitSeconds = asLong(config.getOrDefault("implicitWaitSeconds", 5L));
            driver.manage().timeouts().implicitlyWait(implicitWaitSeconds, TimeUnit.SECONDS);
            LOGGER.info("Android session created successfully. Implicit wait: {} second(s)", implicitWaitSeconds);
            return driver;
        } catch (MalformedURLException e) {
            throw new IllegalArgumentException("Invalid Appium server URL", e);
        }
    }

    private static void applyCapabilities(DesiredCapabilities options, Map<String, Object> capabilities) {
        for (Map.Entry<String, Object> entry : capabilities.entrySet()) {
            options.setCapability(entry.getKey(), entry.getValue());
        }
    }

    private static String asString(Object value) {
        return value == null ? null : String.valueOf(value);
    }

    private static long asLong(Object value) {
        if (value instanceof Number) {
            return ((Number) value).longValue();
        }
        return Long.parseLong(String.valueOf(value));
    }
}
