package pages;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.How;
import org.openqa.selenium.support.PageFactory;

public class HomePage {
	WebDriver driver;

	@FindBy(how = How.CSS, using = ".navbar-brand.logo_cmc")
	WebElement logo;
	@FindBy(how = How.CSS, using = ".nav-item.work .btn-log.login-portal")
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
