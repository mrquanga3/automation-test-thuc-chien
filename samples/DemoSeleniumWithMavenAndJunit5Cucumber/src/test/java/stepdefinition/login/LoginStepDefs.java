package stepdefinition.login;

import dev.failsafe.internal.util.Assert;
import io.cucumber.java.en.Given;
import io.cucumber.java.en.Then;
import io.cucumber.java.en.When;
import org.junit.jupiter.api.Assertions;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;

public class LoginStepDefs {
    WebDriver driver;
    @Given("I opened chrome browser")
    public void iOpenedChromeBrowser() {
        driver = new ChromeDriver();
    }

    @When("I go to opencart login page")
    public void iGoToOpencartLoginPage() {
        driver.get("https://demo.opencart.com/admin/");
    }

    @Then("I see login page")
    public void iSeeLoginPage() {
        WebElement btnLogin = driver.findElement(By.xpath("//button[text() =' Login']"));
        Assertions.assertTrue(btnLogin.isDisplayed());
    }
}
