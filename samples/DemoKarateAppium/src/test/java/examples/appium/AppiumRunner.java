package examples.appium;

import com.intuit.karate.Runner;
import org.junit.jupiter.api.Test;

import static org.junit.jupiter.api.Assertions.assertEquals;

/**
 * JUnit5 Runner voi ScreenshotHook.
 *
 * Su dung Runner.builder() thay vi @Karate.Test de co the gan hook.
 * .hook(new ScreenshotHook()) = dang ky hook chup anh sau moi step.
 */
class AppiumRunner {

    @Test
    void testMessages() {
        var results = Runner.builder()
                .path("classpath:examples/appium/messages.feature")
                .hook(new ScreenshotHook())
                .parallel(1);
        assertEquals(0, results.getFailCount(), results.getErrorMessages());
    }
}
