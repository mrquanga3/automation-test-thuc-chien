package pages;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.How;
import org.openqa.selenium.support.PageFactory;

public class HomePage {
	WebDriver driver;

	@FindBy(how = How.CSS, using = "#logo")
	WebElement logo;
	@FindBy(how = How.CSS, using = "a[href*='account/login']")
	WebElement login;

	public HomePage(WebDriver driver_) {
		driver = driver_;
		PageFactory.initElements(driver, this);
	}

	public boolean isDisplayedLogo() {
		return logo.isDisplayed();
	}

	public String getTitle() {
		return driver.getTitle();
	}
}
