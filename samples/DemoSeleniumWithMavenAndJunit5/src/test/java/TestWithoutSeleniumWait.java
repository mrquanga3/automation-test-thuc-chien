import org.junit.jupiter.api.Test;
import org.openqa.selenium.By;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

import java.time.Duration;

public class TestWithoutSeleniumWait {
    @Test
    void progressBarReachesHundred() {
        ChromeDriver driver = new ChromeDriver();
        try {
            driver.get("https://demoqa.com/progress-bar");
            driver.findElement(By.id("startStopButton")).click();
            WebDriverWait wait = new WebDriverWait(driver, Duration.ofSeconds(60));
            wait.until(ExpectedConditions.presenceOfElementLocated(
                    By.xpath("//div[@aria-valuenow='100']")));
        } finally {
            driver.quit();
        }
    }
}
