package pages;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;

public class InventoryList extends BasePage{
    private WebDriver driver;
    public InventoryList(WebDriver driver){
        super(driver);
        this.driver = driver;
    }

    WebElement titleOfCurrentPage;


    public String getTitle(){
        titleOfCurrentPage =  driver.findElement(By.className("product_label"));
        return titleOfCurrentPage.getText();
    }

    public void clickAItem(String itemName) {
        WebElement productItem =  driver.findElement(By.xpath("//div[@class='inventory_item_name' and text ()='"+itemName+ "']"));
        productItem.click();
    }
}
