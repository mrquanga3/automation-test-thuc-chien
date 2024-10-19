import org.junit.jupiter.api.Assertions;
import org.junit.jupiter.api.Test;
import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

import java.time.Duration;

public class TestWithoutSeleniumWait {
    @Test
    public void demoRadioCheckBox() throws InterruptedException {
        ChromeDriver driver = new ChromeDriver();
        //zoom max man hinh
        driver.manage().window().maximize();
        //vao trang
        driver.get("https://demoqa.com/checkbox");
        // tick vao radio
        // kiem tra da dc tick/selected
        WebElement optionCheckbox1 = driver
                .findElement(By.xpath("//span[@class='rct-checkbox']/*"));
        optionCheckbox1.click();
        WebDriverWait wait = new WebDriverWait(driver, Duration.ofSeconds(1));
        boolean isSelected = wait.until(ExpectedConditions.attributeContains(By.xpath("//span[@class='rct-checkbox']/*"), "class", "rct-icon-check"));
        Assertions.assertTrue(isSelected);
    }
}
