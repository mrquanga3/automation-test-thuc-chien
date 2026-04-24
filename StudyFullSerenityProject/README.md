# Giáo Trình Serenity BDD - Từ Cơ Bản Đến Nâng Cao

> **Dành cho người mới bắt đầu** | Java 17 | Maven | Cucumber | JUnit 5
> Slide có thể xem bằng [Marp](https://marp.app/) hoặc bất kỳ Markdown viewer nào

---

## Mục Lục

| # | Chủ đề | Thời lượng |
|---|--------|-----------|
| 1 | Giới thiệu BDD & Serenity | 30 phút |
| 2 | Cài đặt & Cấu hình | 45 phút |
| 3 | Cấu trúc Project | 30 phút |
| 4 | Viết Feature File (Gherkin) | 60 phút |
| 5 | Step Definitions | 60 phút |
| 6 | Page Object Pattern | 90 phút |
| 7 | UI Testing với Selenium | 90 phút |
| 8 | API Testing với REST Assured | 90 phút |
| 9 | Serenity Reports | 45 phút |
| 10 | Best Practices & CI/CD | 60 phút |

---

# MODULE 1: Giới Thiệu BDD & Serenity

---

## 1.1 — Testing là gì? Tại sao cần Automation?

### Vấn đề với Manual Testing

```
Chu kỳ release nhanh → Regression test tốn nhiều thời gian
Lặp đi lặp lại → Dễ bỏ sót lỗi
Chi phí cao → Cần nhiều tester
```

### Automation Testing giải quyết điều đó

- **Nhanh hơn**: Chạy hàng trăm test case trong vài phút
- **Nhất quán**: Không bị ảnh hưởng bởi yếu tố con người
- **Tái sử dụng**: Viết một lần, chạy nhiều lần
- **Tích hợp CI/CD**: Tự động chạy khi có code mới

---

## 1.2 — BDD là gì?

**BDD = Behavior-Driven Development**

> "Viết test theo ngôn ngữ tự nhiên mà cả Developer, Tester và Business đều hiểu được"

### Three Amigos

**Ba role ** ngồi lại với nhau *trước khi bắt đầu làm một tính năng mới*:

| Role                 | Vai trò | Câu hỏi họ đặt ra |
|----------------------|---------|-------------------|
| **Business (BA/PO)** | Biết khách hàng cần gì | *"Tính năng này phải làm được điều gì?"* |
| **Developer**        | Biết code được hay không | *"Kỹ thuật có vấn đề gì không?"* |
| **Tester**           | Biết test cái gì | *"Trường hợp nào sẽ bị lỗi?"* |

### Ví dụ thực tế — Tính năng Đăng nhập

> **BA:** "Người dùng nhập email + password rồi nhấn Đăng nhập là vào được."
>
> **Tester hỏi:** "Nếu nhập sai password 5 lần thì sao? Tài khoản bị khóa không?"
>
> **Dev hỏi:** "Token hết hạn sau bao lâu? Có cần refresh token không?"
>
> **BA:** "À đúng rồi, sai 5 lần thì khóa 15 phút. Token hết hạn sau 24 giờ."

Kết quả: cả 3 đồng thuận → viết thành Gherkin:

```gherkin
Scenario: Khóa tài khoản sau 5 lần nhập sai
  Given người dùng nhập sai password 5 lần liên tiếp
  When người dùng nhập đúng password lần thứ 6
  Then hệ thống hiển thị "Tài khoản bị khóa 15 phút"
```

> **Tại sao quan trọng?** Three Amigos giúp phát hiện sớm "lỗ hổng" trong yêu cầu
> *trước khi Dev code* — thay vì code xong mới phát hiện thiếu nghiệp vụ.

---

## 1.3 — BDD Flow

```
1. Cuộc họp "Three Amigos"
   (BA + Dev + Tester thống nhất yêu cầu)
        ↓
2. Viết Acceptance Criteria (Gherkin)
   (mô tả hành vi bằng ngôn ngữ tự nhiên)
        ↓
3. Developer implement tính năng
        ↓
4. Tester viết Step Definitions
   (kết nối Gherkin với code Java)
        ↓
5. Chạy test → Báo cáo
        ↓
6. Stakeholder đọc báo cáo (không cần biết code)
```

---

## 1.4 — Serenity BDD là gì?

**Serenity BDD** = Framework automation testing mạnh mẽ cho Java

### Serenity làm được gì?

| Tính năng | Mô tả |
|-----------|-------|
| **BDD Integration** | Tích hợp Cucumber/JUnit natively |
| **Web Testing** | Wrapper cho Selenium WebDriver |
| **API Testing** | Tích hợp REST Assured |
| **Mobile Testing** | Hỗ trợ Appium |
| **Báo cáo đẹp** | HTML report chi tiết, dễ đọc |

---

## 1.5 — Serenity vs Selenium thuần

| Tiêu chí | Selenium thuần | Serenity BDD |
|---------|--------------|-------------|
| Báo cáo | Cần tự viết | Tự động generate |
| Page Object | Tự implement | Built-in hỗ trợ |
| Screenshot | Tự chụp | Tự động chụp khi lỗi |
| BDD | Cần config thủ công | Tích hợp sẵn |
| Retry | Tự implement | Cấu hình đơn giản |
| Parallel | Phức tạp | Hỗ trợ sẵn |

---

## 1.6 — Kiến trúc Serenity

```
┌─────────────────────────────────────────┐
│           TEST RUNNER (JUnit 5)         │
├─────────────────────────────────────────┤
│         CUCUMBER (Feature Files)        │
├──────────────┬──────────────────────────┤
│  Step Defs   │    Serenity Steps        │
├──────────────┴──────────────────────────┤
│         Page Objects / Tasks            │
├─────────────────────────────────────────┤
│   Selenium WebDriver | REST Assured     │
├─────────────────────────────────────────┤
│      Browser / API / Mobile             │
└─────────────────────────────────────────┘
```

---

# MODULE 2: Cài Đặt & Cấu Hình

---

## 2.1 — Yêu cầu hệ thống

### Phần mềm cần cài

```
✅ Java JDK 17+
✅ Maven 3.8+
✅ IntelliJ IDEA (khuyến nghị) hoặc Eclipse
✅ Git
✅ Chrome/Firefox (cho UI testing)
```

### Kiểm tra đã cài chưa

```bash
java -version
# java version "17.0.x"

mvn -version
# Apache Maven 3.8.x

git --version
# git version 2.x.x
```

---

## 2.2 — Tạo Project Maven mới

### Cách 1: IntelliJ IDEA

```
File → New Project → Maven Archetype
GroupId:    com.example
ArtifactId: serenity-demo
Version:    1.0-SNAPSHOT
```

### Cách 2: Terminal

```bash
mvn archetype:generate \
  -DgroupId=com.example \
  -DartifactId=serenity-demo \
  -DarchetypeArtifactId=maven-archetype-quickstart \
  -DinteractiveMode=false
```

---

## 2.3 — Cấu hình pom.xml (Phần 1/3) — Properties

```xml
<?xml version="1.0" encoding="UTF-8"?>
<project xmlns="http://maven.apache.org/POM/4.0.0"
         xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:schemaLocation="http://maven.apache.org/POM/4.0.0
         http://maven.apache.org/xsd/maven-4.0.0.xsd">

    <modelVersion>4.0.0</modelVersion>
    <groupId>com.example</groupId>
    <artifactId>serenity-demo</artifactId>
    <version>1.0-SNAPSHOT</version>

    <properties>
        <maven.compiler.source>17</maven.compiler.source>
        <maven.compiler.target>17</maven.compiler.target>
        <project.build.sourceEncoding>UTF-8</project.build.sourceEncoding>
        <serenity.version>4.1.20</serenity.version>
        <cucumber.version>7.15.0</cucumber.version>
        <junit5.version>5.10.1</junit5.version>
    </properties>
```

---

## 2.4 — Cấu hình pom.xml (Phần 2/3) — Dependencies

```xml
    <dependencies>
        <!-- Serenity Core -->
        <dependency>
            <groupId>net.serenity-bdd</groupId>
            <artifactId>serenity-core</artifactId>
            <version>${serenity.version}</version>
            <scope>test</scope>
        </dependency>

        <!-- Serenity + Cucumber -->
        <dependency>
            <groupId>net.serenity-bdd</groupId>
            <artifactId>serenity-cucumber</artifactId>
            <version>${serenity.version}</version>
            <scope>test</scope>
        </dependency>

        <!-- Serenity + REST Assured (API Testing) -->
        <dependency>
            <groupId>net.serenity-bdd</groupId>
            <artifactId>serenity-rest-assured</artifactId>
            <version>${serenity.version}</version>
            <scope>test</scope>
        </dependency>

        <!-- JUnit 5 -->
        <dependency>
            <groupId>org.junit.jupiter</groupId>
            <artifactId>junit-jupiter</artifactId>
            <version>${junit5.version}</version>
            <scope>test</scope>
        </dependency>
        <dependency>
            <groupId>org.junit.platform</groupId>
            <artifactId>junit-platform-suite</artifactId>
            <version>1.10.1</version>
            <scope>test</scope>
        </dependency>

        <!-- JSON (cho xử lý API body) -->
        <dependency>
            <groupId>org.json</groupId>
            <artifactId>json</artifactId>
            <version>20231013</version>
        </dependency>
    </dependencies>
```

---

## 2.5 — Cấu hình pom.xml (Phần 3/3) — Build Plugins

```xml
    <build>
        <plugins>
            <!-- Maven Surefire: Chạy unit tests -->
            <plugin>
                <groupId>org.apache.maven.plugins</groupId>
                <artifactId>maven-surefire-plugin</artifactId>
                <version>3.1.2</version>
                <configuration>
                    <skip>true</skip>
                </configuration>
            </plugin>

            <!-- Maven Failsafe: Chạy integration/acceptance tests -->
            <plugin>
                <groupId>org.apache.maven.plugins</groupId>
                <artifactId>maven-failsafe-plugin</artifactId>
                <version>3.1.2</version>
                <configuration>
                    <includes>
                        <include>**/*Runner*.java</include>
                    </includes>
                </configuration>
                <executions>
                    <execution>
                        <goals>
                            <goal>integration-test</goal>
                            <goal>verify</goal>
                        </goals>
                    </execution>
                </executions>
            </plugin>

            <!-- Serenity Maven Plugin: Generate reports -->
            <plugin>
                <groupId>net.serenity-bdd.maven.plugins</groupId>
                <artifactId>serenity-maven-plugin</artifactId>
                <version>${serenity.version}</version>
                <executions>
                    <execution>
                        <id>serenity-reports</id>
                        <phase>post-integration-test</phase>
                        <goals>
                            <goal>aggregate</goal>
                        </goals>
                    </execution>
                </executions>
            </plugin>
        </plugins>
    </build>
</project>
```

---

## 2.6 — File serenity.conf

Tạo file `src/test/resources/serenity.conf`:

```hocon
serenity {
  # Tên project hiển thị trong report
  project.name = "Serenity Demo Project"

  # Thư mục chứa test data
  test.data.dir = "src/test/resources/testdata"

  # Chụp screenshot khi nào
  # FOR_FAILURES | FOR_EACH_ACTION | AFTER_EACH_STEP | DISABLED
  take.screenshots = FOR_FAILURES

  # Thời gian chờ tối đa (mili-giây)
  webdriver.timeouts.implicitlywait = 0

  # Chạy song song
  # fork.count = 2
}

webdriver {
  driver = chrome
  autodownload = true

  chrome {
    switches = "--start-maximized;--disable-notifications"
  }
}

environments {
  default {
    webdriver.base.url = "https://www.google.com"
  }

  staging {
    webdriver.base.url = "https://staging.example.com"
  }

  production {
    webdriver.base.url = "https://example.com"
  }
}
```

---

## 2.7 — Cấu trúc thư mục hoàn chỉnh

```
serenity-demo/
├── pom.xml
├── serenity.properties          ← (tùy chọn, thay cho .conf)
└── src/
    ├── main/
    │   └── java/
    │       └── com/example/
    │           └── (production code - nếu có)
    └── test/
        ├── java/
        │   └── com/example/
        │       ├── runners/
        │       │   └── CucumberTestRunner.java
        │       ├── stepdefinitions/
        │       │   └── LoginSteps.java
        │       ├── pages/
        │       │   └── LoginPage.java
        │       └── actions/
        │           └── LoginActions.java
        └── resources/
            ├── serenity.conf
            ├── features/
            │   └── login/
            │       └── login.feature
            └── testdata/
                └── users.csv
```

---

# MODULE 3: Gherkin & Feature Files

---

## 3.1 — Gherkin là gì?

**Gherkin** = Ngôn ngữ mô tả hành vi phần mềm

### Cú pháp cơ bản

```gherkin
Feature: [Tên tính năng]
  [Mô tả tính năng - tùy chọn]

  Background:
    [Các bước chạy trước mỗi Scenario]

  Scenario: [Tên kịch bản]
    Given [Điều kiện ban đầu]
    When  [Hành động người dùng]
    Then  [Kết quả mong đợi]
    And   [Kết quả bổ sung]
    But   [Điều kiện loại trừ / Phủ định]
```

---

## 3.2 — Từ khóa Gherkin

| Từ khóa | Ý nghĩa | Ví dụ |
|---------|---------|-------|
| `Feature` | Mô tả tính năng | Feature: Đăng nhập |
| `Scenario` | Một kịch bản test | Scenario: Đăng nhập thành công |
| `Given` | Điều kiện ban đầu | Given người dùng ở trang login |
| `When` | Hành động | When nhập email và password |
| `Then` | Kết quả mong đợi | Then hiển thị trang chủ |
| `And` | Thêm điều kiện/hành động | And nhấn nút Login |
| `But` | Điều kiện loại trừ | But không lưu password |
| `Background` | Bước dùng chung | Background: Given đã mở browser |
| `Scenario Outline` | Kịch bản có nhiều data | Scenario Outline: Login với nhiều user |
| `Examples` | Bảng data | Examples: \| user \| pass \| |

---

## 3.3 — Feature File đầu tiên

Tạo `src/test/resources/features/login/login.feature`:

```gherkin
Feature: Đăng nhập hệ thống
  Là người dùng đã đăng ký
  Tôi muốn đăng nhập vào hệ thống
  Để truy cập các tính năng cá nhân

  Background:
    Given người dùng mở trình duyệt và vào trang đăng nhập

  Scenario: Đăng nhập thành công với thông tin hợp lệ
    When người dùng nhập email "user@example.com"
    And người dùng nhập password "Password123"
    And người dùng nhấn nút "Đăng nhập"
    Then hệ thống hiển thị trang chủ
    And hiển thị tên "John Doe" ở góc phải màn hình

  Scenario: Đăng nhập thất bại với password sai
    When người dùng nhập email "user@example.com"
    And người dùng nhập password "SaiPassword"
    And người dùng nhấn nút "Đăng nhập"
    Then hệ thống hiển thị thông báo lỗi "Thông tin đăng nhập không đúng"
```

---

## 3.4 — Scenario Outline (Data-Driven Testing)

```gherkin
Feature: Kiểm tra đăng nhập với nhiều loại tài khoản

  Scenario Outline: Đăng nhập với các vai trò khác nhau
    Given người dùng mở trang đăng nhập
    When người dùng nhập email "<email>"
    And người dùng nhập password "<password>"
    And người dùng nhấn nút "Đăng nhập"
    Then hệ thống chuyển đến trang "<trang_chu>"

    Examples:
      | email              | password    | trang_chu   |
      | admin@example.com  | Admin@123   | /dashboard  |
      | user@example.com   | User@123    | /home       |
      | guest@example.com  | Guest@123   | /welcome    |
```

> **Lưu ý**: Mỗi dòng trong `Examples` = 1 Scenario riêng biệt

---

## 3.5 — Tags trong Gherkin

```gherkin
@smoke @regression
Feature: Đăng nhập hệ thống

  @happy-path @critical
  Scenario: Đăng nhập thành công
    Given ...

  @negative @wip
  Scenario: Đăng nhập với email sai định dạng
    Given ...

  @skip
  Scenario: Tính năng chưa hoàn thành
    Given ...
```

### Chạy theo tag

```bash
# Chạy tất cả test có tag @smoke
mvn verify -Dcucumber.filter.tags="@smoke"

# Chạy test có @smoke nhưng KHÔNG có @wip
mvn verify -Dcucumber.filter.tags="@smoke and not @wip"

# Chạy test có @smoke HOẶC @regression
mvn verify -Dcucumber.filter.tags="@smoke or @regression"
```

---

## 3.6 — DocString và DataTable

### DocString — Truyền text nhiều dòng

```gherkin
Scenario: Tạo bài viết mới
  Given người dùng đã đăng nhập
  When người dùng tạo bài viết với nội dung:
    """
    Đây là tiêu đề bài viết
    
    Đây là nội dung bài viết với nhiều dòng.
    Hỗ trợ **markdown** và các ký tự đặc biệt.
    """
  Then bài viết được lưu thành công
```

### DataTable — Truyền bảng dữ liệu

```gherkin
Scenario: Thêm nhiều sản phẩm vào giỏ hàng
  Given người dùng đã đăng nhập
  When người dùng thêm các sản phẩm sau vào giỏ:
    | Tên sản phẩm | Số lượng | Đơn giá |
    | iPhone 15    | 1        | 25000000|
    | AirPods Pro  | 2        | 6000000 |
  Then tổng giá trị giỏ hàng là "37000000"
```

---

# MODULE 4: Test Runner

---

## 4.1 — Tạo Cucumber Test Runner

Tạo `src/test/java/com/example/runners/CucumberTestRunner.java`:

```java
package com.example.runners;

import io.cucumber.junit.platform.engine.Constants;
import org.junit.platform.suite.api.*;

@Suite
@EngineFilter("cucumber")
@SelectClasspathResource("features")
@ConfigurationParameter(
    key = Constants.GLUE_PROPERTY_NAME,
    value = "com.example.stepdefinitions"
)
@ConfigurationParameter(
    key = Constants.PLUGIN_PROPERTY_NAME,
    value = "pretty, json:target/cucumber-reports/cucumber.json"
)
@ConfigurationParameter(
    key = Constants.FILTER_TAGS_PROPERTY_NAME,
    value = "not @skip"
)
public class CucumberTestRunner {
    // Class này chỉ dùng để config — không cần code gì bên trong
}
```

---

## 4.2 — Chạy Test

### Chạy tất cả

```bash
mvn verify
```

### Chạy theo tag

```bash
mvn verify -Dcucumber.filter.tags="@smoke"
```

### Chạy trên environment cụ thể

```bash
mvn verify -Denvironment=staging
```

### Chạy feature file cụ thể

```bash
mvn verify -Dcucumber.features="src/test/resources/features/login"
```

### Xem report sau khi chạy

```
target/site/serenity/index.html
```

---

# MODULE 5: Step Definitions

---

## 5.1 — Step Definition là gì?

**Step Definition** = Code Java tương ứng với mỗi bước Gherkin

```
Feature File (Gherkin)               Step Definition (Java)
─────────────────────────────────────────────────────────────
When người dùng nhập email           @When("người dùng nhập email {string}")
     "user@example.com"    ────────► public void enterEmail(String email) {
                                         loginPage.enterEmail(email);
                                     }
```

---

## 5.2 — Step Definition cơ bản

Tạo `src/test/java/com/example/stepdefinitions/LoginSteps.java`:

```java
package com.example.stepdefinitions;

import io.cucumber.java.en.*;
import net.thucydides.core.annotations.Steps;
import com.example.pages.LoginPage;
import net.serenitybdd.core.pages.WebElementFacade;

public class LoginSteps {

    // Serenity tự inject Page Object — không cần new
    LoginPage loginPage;

    @Given("người dùng mở trình duyệt và vào trang đăng nhập")
    public void userOpensLoginPage() {
        loginPage.open();
    }

    @When("người dùng nhập email {string}")
    public void userEntersEmail(String email) {
        loginPage.enterEmail(email);
    }

    @When("người dùng nhập password {string}")
    public void userEntersPassword(String password) {
        loginPage.enterPassword(password);
    }

    @When("người dùng nhấn nút {string}")
    public void userClicksButton(String buttonText) {
        loginPage.clickButton(buttonText);
    }

    @Then("hệ thống hiển thị trang chủ")
    public void systemShowsHomePage() {
        loginPage.verifyHomePage();
    }

    @Then("hệ thống hiển thị thông báo lỗi {string}")
    public void systemShowsErrorMessage(String expectedMessage) {
        loginPage.verifyErrorMessage(expectedMessage);
    }
}
```

---

## 5.3 — Cucumber Expression Patterns

### Các kiểu tham số

```java
// String — khớp với chuỗi trong dấu ngoặc kép hoặc đơn
@When("người dùng nhập email {string}")
public void enterEmail(String email) { }

// Int — khớp với số nguyên
@When("người dùng chờ {int} giây")
public void waitSeconds(int seconds) { }

// Double — khớp với số thực
@Then("giá sản phẩm là {double} VNĐ")
public void verifyPrice(double price) { }

// Word — khớp với 1 từ (không có khoảng trắng)
@Given("trạng thái là {word}")
public void setStatus(String status) { }

// Regex — tùy chỉnh pattern
@When("^người dùng click vào (button|link|icon) \"([^\"]+)\"$")
public void clickElement(String type, String name) { }
```

---

## 5.4 — Xử lý DataTable trong Step

```java
import io.cucumber.datatable.DataTable;
import java.util.List;
import java.util.Map;

// DataTable dạng List<Map>
@When("người dùng thêm các sản phẩm sau vào giỏ:")
public void addProductsToCart(DataTable dataTable) {
    List<Map<String, String>> products = dataTable.asMaps();

    for (Map<String, String> product : products) {
        String name     = product.get("Tên sản phẩm");
        int quantity    = Integer.parseInt(product.get("Số lượng"));
        long price      = Long.parseLong(product.get("Đơn giá"));

        cartPage.addProduct(name, quantity);
    }
}

// DataTable dạng List<List<String>>
@When("người dùng nhập bảng dữ liệu:")
public void enterTableData(DataTable dataTable) {
    List<List<String>> rows = dataTable.asLists();
    // rows.get(0) = hàng header
    // rows.get(1), rows.get(2)... = dữ liệu
}
```

---

## 5.5 — Before / After Hooks

```java
package com.example.stepdefinitions;

import io.cucumber.java.*;
import net.serenitybdd.core.Serenity;

public class Hooks {

    @Before
    public void beforeEachScenario(Scenario scenario) {
        System.out.println("Bắt đầu Scenario: " + scenario.getName());
        // Setup dữ liệu test, clear cache, v.v.
    }

    @After
    public void afterEachScenario(Scenario scenario) {
        if (scenario.isFailed()) {
            System.out.println("FAILED: " + scenario.getName());
            // Serenity tự chụp screenshot — không cần làm thủ công
        }
    }

    @Before("@db-cleanup")
    public void cleanDatabase() {
        // Chỉ chạy cho scenario có tag @db-cleanup
    }

    @BeforeStep
    public void beforeEachStep() { }

    @AfterStep
    public void afterEachStep() { }
}
```

---

# MODULE 6: Page Object Pattern

---

## 6.1 — Page Object là gì?

**Page Object Pattern** = Mỗi trang web = 1 class Java

```
LoginPage.java ←→ /login
HomePage.java  ←→ /home
CartPage.java  ←→ /cart
```

### Lợi ích

- **Tái sử dụng**: Locator viết 1 lần, dùng nhiều nơi
- **Dễ bảo trì**: Thay đổi UI → chỉ sửa 1 file
- **Dễ đọc**: Step definitions ngắn gọn, dễ hiểu

---

## 6.2 — Serenity Page Object cơ bản

Tạo `src/test/java/com/example/pages/LoginPage.java`:

```java
package com.example.pages;

import net.serenitybdd.core.pages.PageObject;
import net.serenitybdd.core.pages.WebElementFacade;
import net.thucydides.model.annotations.DefaultUrl;
import org.openqa.selenium.support.FindBy;

// URL mặc định khi gọi loginPage.open()
@DefaultUrl("/login")
public class LoginPage extends PageObject {

    // Tìm element theo CSS Selector
    @FindBy(css = "input[name='email']")
    private WebElementFacade emailField;

    // Tìm element theo ID
    @FindBy(id = "password")
    private WebElementFacade passwordField;

    // Tìm element theo XPath
    @FindBy(xpath = "//button[@type='submit']")
    private WebElementFacade loginButton;

    // Tìm theo text
    @FindBy(css = ".error-message")
    private WebElementFacade errorMessage;

    // Các method thao tác với page
    public void enterEmail(String email) {
        emailField.clear();
        emailField.type(email);
    }

    public void enterPassword(String password) {
        passwordField.clear();
        passwordField.type(password);
    }

    public void clickLoginButton() {
        loginButton.click();
    }

    public void clickButton(String buttonText) {
        $("//button[text()='" + buttonText + "']").click();
    }

    public void verifyErrorMessage(String expected) {
        errorMessage.shouldContainText(expected);
    }

    public void verifyHomePage() {
        org.junit.jupiter.api.Assertions.assertTrue(getDriver().getCurrentUrl().contains("/home"));
    }
}
```

---

## 6.3 — WebElementFacade — Các method thông dụng

```java
// Nhập text
element.type("nội dung");
element.clear();
element.clearField();  // clear rồi type

// Click
element.click();
element.clickAndWait();  // click và chờ AJAX

// Kiểm tra trạng thái
element.isVisible();
element.isEnabled();
element.isSelected();
element.isPresent();

// Lấy giá trị
element.getText();
element.getValue();
element.getAttribute("class");

// Assertion — tự động wait
element.shouldBeVisible();
element.shouldNotBeVisible();
element.shouldContainText("expected text");
element.shouldHaveValue("expected value");
element.waitUntilVisible();
element.waitUntilClickable();
```

---

## 6.4 — Tìm element nâng cao

```java
// Tìm bằng CSS (Serenity shortcut)
WebElementFacade btn = $(By.cssSelector(".btn-primary"));
WebElementFacade btn2 = $(".btn-primary");  // CSS shorthand

// Tìm bằng XPath
WebElementFacade row = $(By.xpath("//tr[@data-id='123']"));

// Tìm nhiều elements
List<WebElementFacade> rows = findAll(".table tbody tr");
List<WebElementFacade> links = findAll(By.tagName("a"));

// Tìm element con
WebElementFacade table = $(".data-table");
WebElementFacade cell = table.find(".cell-name");

// Tìm element theo text
$("//button[normalize-space(text())='Lưu']").click();

// Tìm element theo điều kiện
findAll(".product-item")
    .stream()
    .filter(el -> el.getText().contains("iPhone"))
    .findFirst()
    .ifPresent(el -> el.click());
```

---

## 6.5 — Chờ Element (Wait Strategy)

```java
// Serenity tự động chờ — không cần Thread.sleep()

// Chờ element xuất hiện (timeout từ serenity.conf)
element.waitUntilVisible();
element.waitUntilEnabled();
element.waitUntilClickable();
element.waitUntilNotVisible();

// Chờ với timeout tùy chỉnh
element.waitUntilVisible().withTimeoutOf(Duration.ofSeconds(10));

// Chờ điều kiện tùy chỉnh
waitFor(ExpectedConditions.urlContains("/dashboard"));

// Chờ AJAX hoàn thành
waitForAngularRequestsToFinish();

// Serenity implicit wait (cấu hình trong serenity.conf)
// webdriver.timeouts.implicitlywait = 5000  (milliseconds)
```

---

## 6.6 — Page Component — Tái sử dụng phần tử chung

```java
// Component dùng chung trên nhiều trang (navbar, footer, v.v.)
public class NavigationBar extends PageObject {

    @FindBy(css = ".nav-logo")
    private WebElementFacade logo;

    @FindBy(css = ".nav-user-menu")
    private WebElementFacade userMenu;

    public void clickUserMenu() {
        userMenu.click();
    }

    public void logout() {
        clickUserMenu();
        $(".nav-logout").click();
    }
}

// Dùng trong Page Object khác
public class HomePage extends PageObject {

    // Serenity tự inject — không cần new
    NavigationBar navigationBar;

    public void logout() {
        navigationBar.logout();
    }
}
```

---

# MODULE 7: UI Testing với Selenium & Serenity

---

## 7.1 — WebDriver Configuration

### serenity.conf — Cấu hình driver

```hocon
webdriver {
  driver = chrome       # chrome | firefox | edge | safari

  # Tự động download driver phù hợp
  autodownload = true

  chrome {
    # Headless mode (không mở cửa sổ trình duyệt)
    switches = "--headless=new;--no-sandbox;--disable-dev-shm-usage"
    # switches = "--start-maximized"  # Mở full màn hình
  }

  firefox {
    switches = "-headless"
  }
}
```

### Chạy với driver khác qua CLI

```bash
mvn verify -Dwebdriver.driver=firefox
mvn verify -Dwebdriver.driver=chrome
```

---

## 7.2 — Ví dụ thực tế: Test trang Google Search

```gherkin
# features/search/google_search.feature
Feature: Tìm kiếm Google
  
  Scenario: Tìm kiếm thông thường
    Given người dùng mở trang Google
    When người dùng tìm kiếm "Serenity BDD"
    Then trang kết quả hiển thị các kết quả về "Serenity"
```

```java
// pages/GoogleHomePage.java
@DefaultUrl("https://www.google.com")
public class GoogleHomePage extends PageObject {

    @FindBy(name = "q")
    private WebElementFacade searchBox;

    public void searchFor(String keyword) {
        searchBox.type(keyword);
        searchBox.sendKeys(Keys.ENTER);
    }
}

// pages/GoogleResultsPage.java
public class GoogleResultsPage extends PageObject {

    @FindBy(css = "#search .g")
    private List<WebElementFacade> searchResults;

    public void verifyResultsContain(String keyword) {
        searchResults.stream()
            .anyMatch(result -> result.getText().contains(keyword));
    }
}
```

---

## 7.3 — Xử lý các tình huống phức tạp

```java
// Dropdown / Select
public void selectCountry(String country) {
    WebElementFacade dropdown = $("#country-select");
    dropdown.selectByVisibleText(country);
    // hoặc: dropdown.selectByValue("VN");
    // hoặc: dropdown.selectByIndex(2);
}

// Upload file
public void uploadFile(String filePath) {
    $("input[type='file']").sendKeys(filePath);
}

// Scroll đến element
public void scrollToElement(WebElementFacade element) {
    ((JavascriptExecutor) getDriver())
        .executeScript("arguments[0].scrollIntoView(true);", element);
}

// Switch to iframe
public void switchToFrame() {
    getDriver().switchTo().frame($("#my-iframe").getElement());
    // Thao tác trong iframe
    getDriver().switchTo().defaultContent(); // Thoát ra
}

// Alert / Popup
public void acceptAlert() {
    getDriver().switchTo().alert().accept();
}

// Mở tab mới
public void switchToNewTab() {
    ArrayList<String> tabs = new ArrayList<>(getDriver().getWindowHandles());
    getDriver().switchTo().window(tabs.get(1));
}
```

---

## 7.4 — Serenity Steps — Chia nhỏ action

```java
import net.thucydides.core.annotations.Step;

public class LoginActions {

    LoginPage loginPage;

    // @Step giúp action hiển thị rõ trong Serenity Report
    @Step("Mở trang đăng nhập")
    public void openLoginPage() {
        loginPage.open();
    }

    @Step("Đăng nhập với email {0} và password {1}")
    public void loginWith(String email, String password) {
        loginPage.enterEmail(email);
        loginPage.enterPassword(password);
        loginPage.clickLoginButton();
    }

    @Step("Xác nhận đăng nhập thành công")
    public void verifyLoginSuccess() {
        loginPage.verifyHomePage();
    }
}
```

```java
// Dùng trong Step Definitions
public class LoginSteps {

    @Steps
    LoginActions loginActions;

    @When("người dùng đăng nhập với {string} và {string}")
    public void login(String email, String password) {
        loginActions.loginWith(email, password);
    }
}
```

---

# MODULE 8: API Testing với REST Assured

---

## 8.1 — REST Assured trong Serenity

**REST Assured** = Thư viện test REST API trong Java

```
Serenity + REST Assured = API test có báo cáo đẹp
```

### Các method HTTP

```java
import static net.serenitybdd.rest.SerenityRest.*;

// GET
given().when().get("/api/users")

// POST
given().body(requestBody).when().post("/api/users")

// PUT
given().body(requestBody).when().put("/api/users/1")

// DELETE
given().when().delete("/api/users/1")

// PATCH
given().body(patchBody).when().patch("/api/users/1")
```

---

## 8.2 — Ví dụ: Test GET API

```gherkin
# features/api/user_api.feature
Feature: User API

  Scenario: Lấy danh sách người dùng
    Given API base URL là "https://reqres.in"
    When gọi GET "/api/users?page=1"
    Then response status code là 200
    And response body chứa trường "data" có kiểu là mảng
    And mỗi user trong "data" có trường "email"
```

```java
// stepdefinitions/UserApiSteps.java
import static net.serenitybdd.rest.SerenityRest.*;
import static org.hamcrest.Matchers.*;
import io.restassured.response.Response;

public class UserApiSteps {

    private Response response;

    @Given("API base URL là {string}")
    public void setBaseUrl(String baseUrl) {
        RestAssured.baseURI = baseUrl;
    }

    @When("gọi GET {string}")
    public void callGet(String endpoint) {
        response = given()
            .header("Accept", "application/json")
            .when()
            .get(endpoint)
            .then()
            .extract().response();
    }

    @Then("response status code là {int}")
    public void verifyStatusCode(int expectedCode) {
        response.then().statusCode(expectedCode);
    }
}
```

---

## 8.3 — Ví dụ: Test POST API

```java
import io.restassured.http.ContentType;
import org.json.JSONObject;

public class UserApiSteps {

    @When("gọi POST {string} với dữ liệu:")
    public void callPost(String endpoint, DataTable dataTable) {
        Map<String, String> data = dataTable.asMap(String.class, String.class);

        JSONObject requestBody = new JSONObject();
        data.forEach(requestBody::put);

        response = given()
            .contentType(ContentType.JSON)
            .header("Authorization", "Bearer " + getToken())
            .body(requestBody.toString())
            .when()
            .post(endpoint)
            .then()
            .extract().response();
    }

    @Then("response body chứa {string} là {string}")
    public void verifyResponseField(String field, String value) {
        response.then().body(field, equalTo(value));
    }

    @Then("response body chứa {string} không rỗng")
    public void verifyFieldNotEmpty(String field) {
        response.then().body(field, notNullValue());
    }
}
```

---

## 8.4 — Xác thực Response nâng cao

```java
// Kiểm tra nhiều field cùng lúc
response.then()
    .statusCode(201)
    .body("id", notNullValue())
    .body("name", equalTo("John Doe"))
    .body("email", containsString("@"))
    .body("roles", hasItem("USER"))
    .body("address.city", equalTo("Hanoi"));

// Kiểm tra mảng
response.then()
    .body("data.size()", greaterThan(0))
    .body("data[0].id", notNullValue())
    .body("data.email", everyItem(containsString("@")));

// Lấy giá trị từ response
String userId = response.jsonPath().getString("id");
int totalCount = response.jsonPath().getInt("total");
List<String> emails = response.jsonPath().getList("data.email");

// Response time
response.then().time(lessThan(2000L));  // < 2 giây
```

---

## 8.5 — API Test với Authentication

```java
// Basic Auth
given()
    .auth().basic("username", "password")
    .when().get("/api/secure")

// Bearer Token
given()
    .header("Authorization", "Bearer " + accessToken)
    .when().get("/api/secure")

// OAuth 2.0
given()
    .auth().oauth2(accessToken)
    .when().get("/api/secure")

// API Key
given()
    .header("x-api-key", "your-api-key")
    .when().get("/api/data")

// Lấy token từ login API rồi dùng cho request tiếp theo
String token = given()
    .body("{\"username\":\"admin\",\"password\":\"admin123\"}")
    .contentType(ContentType.JSON)
    .when().post("/api/auth/login")
    .then().statusCode(200)
    .extract().path("access_token");
```

---

## 8.6 — Tổ chức API Steps tái sử dụng

```java
// actions/ApiHelper.java
public class ApiHelper {

    private static String authToken;

    @Step("Lấy access token")
    public String getAuthToken(String username, String password) {
        if (authToken == null) {
            authToken = given()
                .contentType(ContentType.JSON)
                .body(String.format(
                    "{\"username\":\"%s\",\"password\":\"%s\"}",
                    username, password))
                .when().post("/api/auth/login")
                .then().statusCode(200)
                .extract().path("access_token");
        }
        return authToken;
    }

    @Step("Tạo user mới: {0}")
    public Response createUser(String name, String email) {
        return given()
            .header("Authorization", "Bearer " + authToken)
            .contentType(ContentType.JSON)
            .body(String.format(
                "{\"name\":\"%s\",\"email\":\"%s\"}", name, email))
            .when().post("/api/users");
    }
}
```


---

# MODULE 9: Serenity Reports

---

## 9.1 — Serenity Report là gì?

Sau khi chạy test, Serenity tự động generate báo cáo đẹp tại:

```
target/site/serenity/index.html
```

### Nội dung Report

- **Test Results**: Pass/Fail/Pending/Skipped
- **Feature Coverage**: Tỷ lệ feature được test
- **Requirements Traceability**: Liên kết test ↔ requirement
- **Screenshots**: Chụp màn hình khi lỗi
- **Step Details**: Chi tiết từng bước thực thi
- **History**: So sánh kết quả qua các lần chạy

---

## 9.2 — Tùy chỉnh Report

```java
// Thêm thông tin vào report
import net.thucydides.core.annotations.Step;
import net.serenitybdd.core.Serenity;

@Step("Kiểm tra dữ liệu sản phẩm")
public void verifyProductData(String name, double price) {
    // Ghi chú vào report
    Serenity.recordReportData()
        .withTitle("Dữ liệu sản phẩm")
        .andContents("Tên: " + name + "\nGiá: " + price);

    // Highlight thông tin quan trọng
    Serenity.reportThat("Giá sản phẩm hợp lệ",
        () -> assertThat(price).isGreaterThan(0));
}
```

```java
// Đặt tên màn hình trong report
Serenity.takeScreenshot();  // Chụp ngay lập tức
```

---

## 9.3 — Cấu hình serenity.conf cho Report

```hocon
serenity {
  project.name = "My E-Commerce Test Suite"

  # Thư mục output của report
  outputDirectory = target/site/serenity

  # Chụp screenshot
  # FOR_FAILURES | FOR_EACH_ACTION | AFTER_EACH_STEP | DISABLED
  take.screenshots = FOR_FAILURES

  # Thêm thông tin issues (Jira, v.v.)
  # issue.tracker.url = "https://jira.company.com/browse/{0}"

  # Hiển thị tên đầy đủ của test
  display.full.test.names = true
}
```

---

## 9.4 — Serenity Living Documentation

```gherkin
# Thêm narrative vào Feature để mô tả rõ hơn
@requirement-id:LOGIN-001
Feature: Đăng nhập hệ thống
  Narrative:
  Là người dùng đã đăng ký
  Tôi muốn đăng nhập vào hệ thống
  Để truy cập các tính năng cá nhân của mình

  @story:LOGIN-HAPPY-PATH
  Scenario: Đăng nhập thành công
    ...
```

---

# MODULE 10: Best Practices & CI/CD

---

## 10.1 — Best Practices: Feature Files

```gherkin
# ✅ ĐÚNG — Viết theo ngôn ngữ nghiệp vụ
Scenario: Khách hàng mua hàng thành công
  Given khách hàng đã thêm iPhone 15 vào giỏ
  When khách hàng thanh toán bằng thẻ Visa
  Then đơn hàng được tạo và email xác nhận được gửi

# ❌ SAI — Viết theo góc nhìn kỹ thuật
Scenario: Click button và verify DB
  Given driver.get("https://shop.com/cart")
  When driver.findElement(By.id("checkout")).click()
  Then SELECT * FROM orders WHERE status = 'created'
```

---

## 10.2 — Best Practices: Page Objects

```java
// ✅ ĐÚNG — Locator rõ ràng, method một việc
public class CheckoutPage extends PageObject {

    @FindBy(id = "card-number")
    private WebElementFacade cardNumberField;

    public void enterCardNumber(String number) {
        cardNumberField.clear();
        cardNumberField.type(number);
    }
}

// ❌ SAI — Method làm quá nhiều việc
public class CheckoutPage extends PageObject {
    public void doEverything(String card, String cvv, String name) {
        // 50 dòng code...
    }
}
```

---

## 10.3 — Best Practices: Step Definitions

```java
// ✅ ĐÚNG — Step Definition gọi Page Object
@When("người dùng nhập số thẻ {string}")
public void enterCardNumber(String number) {
    checkoutPage.enterCardNumber(number);
}

// ❌ SAI — Logic Selenium nằm trong Step Definition
@When("người dùng nhập số thẻ {string}")
public void enterCardNumber(String number) {
    driver.findElement(By.id("card-number")).sendKeys(number);
    // Đây là anti-pattern!
}
```

---

## 10.4 — Best Practices: Test Data

```java
// ✅ ĐÚNG — Test data tách biệt
// testdata/users.csv
// email,password,role
// admin@test.com,Admin@123,ADMIN

// Đọc từ file
@Given("người dùng đăng nhập với tài khoản {string}")
public void loginWithAccount(String accountType) {
    UserData user = TestDataReader.getUser(accountType);
    loginPage.loginWith(user.getEmail(), user.getPassword());
}

// ❌ SAI — Hardcode data trong test
@When("đăng nhập")
public void login() {
    loginPage.loginWith("admin@test.com", "Admin@123");
}
```

---

## 10.5 — Chạy song song (Parallel Execution)

```hocon
# serenity.conf
serenity {
  fork.count = 4   # Chạy 4 scenarios cùng lúc
}
```

```xml
<!-- pom.xml -->
<plugin>
    <groupId>org.apache.maven.plugins</groupId>
    <artifactId>maven-failsafe-plugin</artifactId>
    <configuration>
        <parallel>methods</parallel>
        <threadCount>4</threadCount>
    </configuration>
</plugin>
```

---

## 10.6 — Tích hợp CI/CD (GitHub Actions)

```yaml
# .github/workflows/test.yml
name: Serenity Tests

on:
  push:
    branches: [ main, develop ]
  pull_request:
    branches: [ main ]

jobs:
  test:
    runs-on: ubuntu-latest

    steps:
      - name: Checkout code
        uses: actions/checkout@v4

      - name: Setup Java 17
        uses: actions/setup-java@v4
        with:
          java-version: '17'
          distribution: 'temurin'

      - name: Run Serenity Tests
        run: mvn verify -Dwebdriver.driver=chrome
          -Dwebdriver.chrome.options="--headless=new --no-sandbox"

      - name: Upload Serenity Report
        uses: actions/upload-artifact@v4
        if: always()
        with:
          name: serenity-report
          path: target/site/serenity/
```

---

## 10.7 — Debugging khi test fail

```bash
# 1. Xem log chi tiết
mvn verify -X

# 2. Chạy 1 scenario cụ thể
mvn verify -Dcucumber.filter.tags="@debug"

# 3. Chạy 1 feature file
mvn verify -Dcucumber.features="src/test/resources/features/login/login.feature"

# 4. Xem Serenity report
open target/site/serenity/index.html

# 5. Xem log file
cat target/failsafe-reports/*.txt
```

```java
// Tạm thời bật screenshot mỗi step để debug
// serenity.conf: take.screenshots = AFTER_EACH_STEP

// In ra console trong test
Serenity.recordReportData()
    .withTitle("Debug info")
    .andContents("URL hiện tại: " + getDriver().getCurrentUrl());
```

---

# MODULE 11: Bài Tập Thực Hành

---

## Bài 1 — Level: Cơ bản

### Mục tiêu: Test Google Search

1. Tạo project Serenity mới với Maven
2. Cấu hình `pom.xml` và `serenity.conf`
3. Viết feature file:

```gherkin
Feature: Google Search
  Scenario: Tìm kiếm và xem kết quả
    Given người dùng mở Google
    When người dùng tìm "Serenity BDD"
    Then trang kết quả hiển thị ít nhất 5 kết quả
```

4. Tạo `GoogleHomePage` và `GoogleResultsPage`
5. Viết `SearchSteps`
6. Chạy test và xem report

---

## Bài 2 — Level: Trung bình

### Mục tiêu: Test API JSONPlaceholder

Dùng API công khai: `https://jsonplaceholder.typicode.com`

```gherkin
Feature: User API
  Scenario: Lấy thông tin user
    Given API endpoint là "https://jsonplaceholder.typicode.com"
    When gọi GET "/users/1"
    Then status code là 200
    And trường "name" là "Leanne Graham"
    And trường "email" chứa "@"

  Scenario: Tạo post mới
    When gọi POST "/posts" với body:
      | title  | My Test Post |
      | body   | Content here |
      | userId | 1            |
    Then status code là 201
    And response chứa trường "id"
```

---

## Bài 3 — Level: Nâng cao

### Mục tiêu: Test toàn bộ luồng e-commerce

Dùng site demo: `https://www.saucedemo.com`

```
Luồng 1 — Happy path:
  1. Đăng nhập với standard_user / secret_sauce
  2. Thêm 2 sản phẩm vào giỏ
  3. Checkout với thông tin hợp lệ
  4. Xác nhận đơn hàng thành công

Luồng 2 — Negative:
  1. Đăng nhập với locked_out_user
  2. Verify thông báo lỗi

Luồng 3 — Data-driven:
  Dùng Scenario Outline test với 3 loại user
```

**Yêu cầu**: Áp dụng Page Object Pattern, Tags, và xem Serenity Report

---

# Tổng Kết

---

## Roadmap học Serenity

```
Tuần 1:  BDD concepts + Setup + Gherkin cơ bản
Tuần 2:  Step Definitions + Page Object Pattern
Tuần 3:  UI Testing nâng cao (waits, iframe, alerts)
Tuần 4:  API Testing với REST Assured
Tuần 5:  CI/CD integration + Best practices
Tuần 6+: Thực hành project thực tế
```

---

## Tài nguyên học thêm

| Tài nguyên | Link |
|-----------|------|
| Serenity BDD Docs | serenity-bdd.info |
| Serenity GitHub | github.com/serenity-bdd |
| Cucumber Docs | cucumber.io/docs |
| REST Assured | rest-assured.io |
| Demo site UI | saucedemo.com |
| Demo API | jsonplaceholder.typicode.com |
| Demo API | reqres.in |

---

## Checklist trước khi đi làm thực tế

```
✅ Hiểu BDD là gì và Three Amigos
✅ Viết được Feature File với Gherkin
✅ Tạo được Page Object với Serenity
✅ Viết được Step Definitions
✅ Test được API với REST Assured
✅ Đọc được Serenity Report
✅ Sử dụng Tags để lọc test
✅ Cấu hình được serenity.conf
✅ Chạy test trên CI/CD
✅ Debug khi test fail
```

---

> **Chúc mừng!** Bạn đã hoàn thành giáo trình Serenity BDD.
>
> Thực hành là chìa khóa — hãy làm bài tập và xây dựng project thực tế!

---

*Giáo trình này có thể xem dạng slide bằng:*
- **VS Code**: Extension "Marp for VS Code"
- **Online**: [marp.app](https://marp.app)
- **CLI**: `npx @marp-team/marp-cli README.md --html`
