package test;

import org.testng.Assert;
import org.testng.annotations.Test;

import pages.HomePage;

public class TestHomePage extends TestTemplate {

	@Test
	public void testTitle() {
		HomePage homePage = new HomePage(driver);
		Assert.assertEquals("Tuyển dụng CMC Corporation", homePage.getTitle());
	}

	@Test
	public void testLogoIsDisplayed() {
		HomePage homePage = new HomePage(driver);
		Assert.assertEquals(true, homePage.isDisplayedLogo());
	}
}