import org.junit.jupiter.api.Assertions;
import org.junit.jupiter.api.Test;
import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.chrome.ChromeOptions;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

import java.time.Duration;

public class LoginTestcaseTest {
    @Test
    public void loginFail() throws InterruptedException {
        ChromeOptions options = new ChromeOptions();
        ChromeDriver driver = new ChromeDriver();
        driver.manage().window().maximize();
        //vao trang
        driver.get("https://demoqa.com/progress-bar");
        //tim nut start
        WebElement startStopButtonEl = driver.findElement(By.id("startStopButton"));
        startStopButtonEl.click();
        //tim so 100
        WebElement colorChangeEl = driver.findElement(By.xpath("//div[@aria-valuenow='100']"));

    }
}
