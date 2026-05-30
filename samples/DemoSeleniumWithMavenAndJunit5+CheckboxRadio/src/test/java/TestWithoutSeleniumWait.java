import org.junit.jupiter.api.Assertions;
import org.junit.jupiter.api.Test;
import org.openqa.selenium.By;
import org.openqa.selenium.JavascriptExecutor;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

import java.time.Duration;

public class TestWithoutSeleniumWait {
    @Test
    public void demoRadioCheckBox() {
        ChromeDriver driver = new ChromeDriver();
        try {
            //zoom max man hinh
            driver.manage().window().maximize();
            //vao trang
            driver.get("https://demoqa.com/checkbox");

            // demoqa now renders the checkbox tree with the rc-tree library
            // (span.rc-tree-checkbox), not the old react-checkbox-tree (rct-*).
            By checkbox = By.cssSelector("span.rc-tree-checkbox");

            WebDriverWait wait = new WebDriverWait(driver, Duration.ofSeconds(20));
            WebElement optionCheckbox1 = wait.until(ExpectedConditions.presenceOfElementLocated(checkbox));

            // demoqa overlays ads/fixed banners that intercept native clicks,
            // so scroll into view and click via JS for reliability.
            ((JavascriptExecutor) driver).executeScript("arguments[0].scrollIntoView({block:'center'});", optionCheckbox1);
            ((JavascriptExecutor) driver).executeScript("arguments[0].click();", optionCheckbox1);

            // when ticked, rc-tree marks the checkbox with rc-tree-checkbox-checked
            boolean isSelected = wait.until(
                    ExpectedConditions.attributeContains(checkbox, "class", "rc-tree-checkbox-checked"));
            Assertions.assertTrue(isSelected);
        } finally {
            driver.quit();
        }
    }
}
