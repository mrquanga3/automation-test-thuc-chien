import org.junit.jupiter.api.Test;
import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;

public class TestWithoutSeleniumWait {
    @Test
    public void loginFail() throws InterruptedException {
        ChromeDriver driver = new ChromeDriver();
        driver.manage().window().maximize();
        //vao trang
        driver.get("https://demoqa.com/progress-bar");
        //tim nut start va click
        WebElement startStopButtonEl = driver.findElement(By.id("startStopButton"));
        startStopButtonEl.click();
        Thread.sleep(30000);
        //tim so 100
        WebElement colorChangeEl = driver.findElement(By.xpath("//div[@aria-valuenow='100']"));

    }
}
