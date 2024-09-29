import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;

public class DemoSelenium {
    public static void main(String [] args) throws InterruptedException {
        System.out.println("Hello world");
        ChromeDriver driver = new ChromeDriver();
        driver.get("https://demo.opencart.com/admin/");
        Thread.sleep(10000);
        WebElement username = driver.findElement(By.xpath("//input[@name='username']"));
        username.clear();
        username.sendKeys("admin");
        WebElement password = driver.findElement(By.xpath("//input[@name='password']"));
        password.clear();
        password.sendKeys("admin");

        WebElement submit = driver.findElement(By.xpath("//button[@type='submit']/i"));
        submit.click();

        driver.quit();

    }
}
