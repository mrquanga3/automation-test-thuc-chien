package examples.appium;

import com.intuit.karate.RuntimeHook;
import com.intuit.karate.core.ScenarioRuntime;
import com.intuit.karate.core.Step;
import com.intuit.karate.core.StepResult;
import com.intuit.karate.driver.Driver;

/**
 * Hook tu dong chup anh man hinh sau moi step trong Karate test.
 *
 * Cach hoat dong:
 * - Karate goi afterStep() SAU MOI STEP (ke ca step FAIL)
 * - Hook kiem tra driver da khoi tao chua (sr.engine.driver)
 * - Neu co driver -> goi driver.screenshot() de chup man hinh
 * - screenshot(true) = chup + embed vao Karate report (HTML)
 *
 * Loi ich so voi goi screenshot() thu cong:
 * 1. Khong lap code - viet 1 lan, ap dung moi step
 * 2. Chup duoc ca khi FAIL - vi afterStep() luon chay bat ke step pass hay fail
 * 3. De bao tri - them/xoa step khong can them/xoa screenshot
 */
public class ScreenshotHook implements RuntimeHook {

    @Override
    public void afterStep(StepResult result, ScenarioRuntime sr) {
        // Lay driver tu Karate variables (vi engine.driver la protected)
        Object driver = sr.engine.getVariable("driver");
        if (driver instanceof Driver d) {
            try {
                d.screenshot(true);
            } catch (Exception e) {
                sr.logger.warn("Screenshot failed: {}", e.getMessage());
            }
        }
    }
}
