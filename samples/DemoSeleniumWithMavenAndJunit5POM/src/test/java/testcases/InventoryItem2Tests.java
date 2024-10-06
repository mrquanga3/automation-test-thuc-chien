package testcases;

import org.junit.jupiter.api.Assertions;
import org.junit.jupiter.api.Test;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.chrome.ChromeDriver;
import pages.InventoryItem;
import pages.InventoryList;
import pages.Login;

import java.time.Duration;

public class InventoryItem2Tests extends BaseTests{
    @Test
    public void testLogin() throws InterruptedException {
        // Page login
        Login login = new Login(driver);
        login.gotoLoginPage();
        Assertions.assertEquals("Swag Labs", login.getTitleOfPageInBrowser());
        login.enterUsername("standard_user");
        login.enterPassword("secret_sauce");
        login.clickSubmit();

        // Inventory List
        InventoryList inventoryList = new InventoryList(driver);

        Assertions.assertEquals("Products" , inventoryList.getTitle());

        String productItem = "Sauce Labs Backpack";
        inventoryList.clickAItem(productItem);

        // Inventory Item
        InventoryItem inventoryItem = new InventoryItem(driver);
        Assertions.assertEquals(productItem , inventoryItem.getTitleOfProduct());
        Assertions.assertEquals("Swag Labs", inventoryItem.getTitleOfPageInBrowser());
        //driver.quit();
    }
}
