package pages;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;

import java.time.Duration;

public class Login extends BasePage{

    @FindBy(id="user-name")
    WebElement username;
    @FindBy(id="password")
    WebElement password;
    WebElement submit;
    WebDriver driver;
    public Login(WebDriver driver){
        super(driver);
        this.driver = driver;
        PageFactory.initElements(driver, this);
    }
    public void gotoLoginPage() {
        driver.get("https://www.saucedemo.com/v1");
    }
    public void enterUsername(String strUser) {
        username.sendKeys(strUser);
    }

    public void enterPassword(String strPass) {
        password.sendKeys(strPass);
    }
    public void clickSubmit(){

        submit = driver.findElement(By.id("login-button"));
        submit.click();
    }
}
