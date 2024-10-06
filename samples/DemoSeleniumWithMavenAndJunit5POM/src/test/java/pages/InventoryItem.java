package pages;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;

public class InventoryItem extends BasePage{
    private WebElement titleOfProduct;
    private WebDriver driver;
    public InventoryItem(WebDriver driver){
        super(driver);
        this.driver = driver;
    }
    public String getTitleOfProduct() {
        titleOfProduct =  driver.findElement(By.className("inventory_details_name"));
        return titleOfProduct.getText();
    }
}
