package test;

import java.util.concurrent.TimeUnit;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.chrome.ChromeDriver;
import org.testng.annotations.AfterClass;
import org.testng.annotations.BeforeClass;

import common.Settings;

public class TestTemplate {
	WebDriver driver;

	@BeforeClass
	public void setUp() {
		driver = new ChromeDriver();
		driver.manage().window().maximize();
		driver.get(Settings.URL);
		driver.manage().timeouts().implicitlyWait(10, TimeUnit.MICROSECONDS);
	}

	@AfterClass
	public void tearnDown() {
		driver.quit();
	}
}
