package cmc.com.vn.selenium.exam2;

import static org.junit.Assert.assertTrue;

import org.junit.AfterClass;
import org.junit.BeforeClass;
import org.junit.Test;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;

public class JunitAndSelenium {
	static WebDriver browser;

	@BeforeClass
	public static void setUp() {
		browser = new ChromeDriver();
		browser.navigate().to("https://www.google.com.vn/");
	}

	@Test
	public void testSearch1() {
		WebElement searchBtn = browser.findElement(By.name("q"));
		searchBtn.sendKeys("Test");
		WebElement searchHpLogo = browser.findElement(By.id("hplogo"));
		searchHpLogo.click();
		assertTrue(browser.getTitle().contains("Google"));
	}

	@Test
	public void testSearch2() {
		browser.navigate().refresh();
		WebElement searchBtn = browser.findElement(By.name("q"));
		searchBtn.sendKeys("Test");
		WebElement searchHpLogo = browser.findElement(By.id("hplogo"));
		searchHpLogo.click();
	}

	@AfterClass
	public static void tearDown() {
		browser.close();
	}

}