import org.junit.jupiter.api.Assertions;
import org.junit.jupiter.api.Test;
import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;

public class LoginTestcaseTest {
    @Test
    public void loginFail() throws InterruptedException {
        ChromeDriver driver = new ChromeDriver();
        driver.get("https://demo.opencart.com/admin/");
        Thread.sleep(10000);
        Assertions.assertEquals("Administration", driver.getTitle());
        WebElement username = driver.findElement(By.xpath("//input[@name='username']"));
        username.clear();
        username.sendKeys("admin");
        WebElement password = driver.findElement(By.xpath("//input[@name='password']"));
        password.clear();
        password.sendKeys("admin");

        WebElement submit = driver.findElement(By.xpath("//button[@type='submit']/i"));
        submit.click();
        Thread.sleep(5000);
        WebElement error = driver.findElement(By.cssSelector(".alert.alert-danger.alert-dismissible"));
        Assertions.assertEquals("No match for Username and/or Password.", error.getText());
        Integer.
        driver.quit();
    }
}
