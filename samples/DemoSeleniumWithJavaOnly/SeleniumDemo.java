import org.openqa.selenium.chrome.ChromeDriver;

public class SeleniumDemo {
    public static void main(String[] args){
        System.out.println("Hello world");
        ChromeDriver driver = new ChromeDriver();
        driver.get("https://google.com.vn");
    }
}
