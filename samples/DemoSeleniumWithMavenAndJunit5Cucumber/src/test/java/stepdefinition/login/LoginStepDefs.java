package stepdefinition.login;

import io.cucumber.java.After;
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
        driver.get("https://opencart.abstracta.us/admin/");
    }

    @Then("I see login page")
    public void iSeeLoginPage() {
        WebElement btnLogin = driver.findElement(By.xpath("//button[text() =' Login']"));
        Assertions.assertTrue(btnLogin.isDisplayed());
    }

    @After
    public void afterScenario() {
        if (driver != null) driver.quit();
    }
}
