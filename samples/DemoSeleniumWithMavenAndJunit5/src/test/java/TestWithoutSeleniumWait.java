import org.junit.jupiter.api.AfterAll;
import org.junit.jupiter.api.BeforeAll;
import org.junit.jupiter.api.Test;
import org.openqa.selenium.By;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.chrome.ChromeOptions;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

import java.time.Duration;

public class TestWithoutSeleniumWait {
    static Process mockServer;

    @BeforeAll
    static void startMockServer() throws Exception {
        String scriptPath = TestWithoutSeleniumWait.class.getClassLoader()
                .getResource("progress_bar_server.py").getPath();
        mockServer = new ProcessBuilder("python3", scriptPath)
                .redirectErrorStream(true)
                .start();
        Thread.sleep(1000);
    }

    @AfterAll
    static void stopMockServer() {
        if (mockServer != null) mockServer.destroyForcibly();
    }

    @Test
    void progressBarReachesHundred() {
        System.setProperty("webdriver.chrome.driver", "/tmp/chromedriver-linux64/chromedriver");
        ChromeOptions options = new ChromeOptions();
        options.setBinary("/opt/pw-browsers/chromium-1194/chrome-linux/chrome");
        options.addArguments("--headless=new", "--no-sandbox", "--disable-dev-shm-usage",
                "--disable-gpu", "--window-size=1920,1080");
        ChromeDriver driver = new ChromeDriver(options);
        try {
            driver.get("http://localhost:29081");
            driver.findElement(By.id("startStopButton")).click();
            WebDriverWait wait = new WebDriverWait(driver, Duration.ofSeconds(30));
            wait.until(ExpectedConditions.presenceOfElementLocated(
                    By.xpath("//div[@aria-valuenow='100']")));
        } finally {
            driver.quit();
        }
    }
}
