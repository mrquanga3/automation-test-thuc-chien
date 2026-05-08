# Automation Test Training

Repository tổng hợp tài liệu và bài tập thực chiến về kiểm thử tự động (automation testing), bao gồm Selenium WebDriver, Karate, Appium, WebdriverIO và các framework phổ biến.

---

## Cấu trúc thư mục

```
automation-test-thuc-chien/
├── demos/                        # Demo đơn giản để bắt đầu
├── samples/                      # 18 dự án mẫu theo từng chủ đề
├── documents/                    # Tài liệu học tập (slides)
└── web for testing/              # Ứng dụng web dùng để test
```

---

## demos/

Chứa dự án demo đơn giản nhất để người học làm quen với Selenium WebDriver.

```
demos/
└── DemoSelenium/                 # Demo Selenium với Eclipse IDE
    └── src/
        └── demo1/
            └── TestSeleniumWebdriver.java   # Mở Chrome, truy cập trang web
```

---

## samples/

18 dự án mẫu được phân chia theo framework và chủ đề, từ cơ bản đến nâng cao.

```
samples/
├── DemoReadFile/                         # Đọc file dữ liệu trong Java
│   └── src/
│       ├── com/cmc/demo/readfile/
│       │   └── ReadFile.java             # Đọc file text thông thường
│       └── account.txt                   # File dữ liệu mẫu
│
├── DemoJunit4/                           # JUnit 4 cơ bản
│   └── src/samples/junit4demo/
│       └── TestWithJunit4.java           # Test case với JUnit 4
│
├── DemoJunitSeleniumExam2/               # Kết hợp JUnit + Selenium
│   └── src/cmc/com/vn/selenium/exam2/
│       └── JunitAndSelenium.java         # Test UI với JUnit và Selenium
│
├── DemoSeleniumWithJavaNoMaven/          # Selenium không dùng Maven (thủ công)
│   └── DemoSelenium.java                 # Cấu hình thư viện thủ công qua IDE
│
├── DemoSeleniumWithJavaOnly/             # Selenium standalone với IntelliJ
│   └── SeleniumDemo.java                 # Mở google.com.vn bằng ChromeDriver
│
├── DemoSeleniumWithMavenAndJunit5/       # Maven + JUnit 5 + Selenium 4
│   ├── pom.xml                           # Selenium 4.25.0, JUnit Jupiter 5.11.1
│   └── src/test/java/
│       └── TestWithoutSeleniumWait.java  # Test cơ bản không dùng explicit wait
│
├── DemoSeleniumWithMavenAndJunit5+CheckboxRadio/   # Tương tác Checkbox & Radio
│   ├── pom.xml
│   └── src/test/java/
│       └── TestWithoutSeleniumWait.java  # Test thao tác với form elements
│
├── DemoSeleniumWithMavenAndJunit5NotUseSeleniumWait/  # Demo không dùng wait
│   ├── pom.xml
│   └── src/test/java/
│       └── TestWithoutSeleniumWait.java  # Minh họa vấn đề khi bỏ qua wait
│
├── DemoSeleniumWithMavenAndJunit5POM/    # Page Object Model với JUnit 5
│   ├── pom.xml
│   └── src/test/java/
│       └── TestWithoutSeleniumWait.java  # Test áp dụng mẫu POM
│
├── DemoPOM/                              # POM nâng cao với TestNG
│   ├── pom.xml                           # Selenium 3.141.59, TestNG 7.1.0
│   ├── testng.xml                        # Cấu hình test suite
│   └── src/
│       ├── common/
│       │   └── Settings.java             # Cấu hình chung (URL, driver)
│       ├── pages/
│       │   └── HomePage.java             # Page Object cho trang chủ CMC
│       └── test/
│           ├── TestTemplate.java         # Base class setup/teardown
│           └── TestHomePage.java         # Test title, logo trang chủ
│
├── DemoRestfulAPIWebSerivce/             # Kiểm thử REST API
│   ├── pom.xml                           # REST-assured 3.0.0, TestNG 7.1.0
│   └── src/test/java/test/
│       └── SimpleGetTest.java            # GET request, kiểm tra response
│
├── DemoSeleniumWithMavenAndJunit5Cucumber/   # BDD Cucumber + JUnit 5
│   ├── pom.xml                               # Cucumber 7.18.0, Selenium 4.25.0
│   └── src/test/
│       ├── java/
│       │   ├── runners/
│       │   │   ├── LoginRunner.java          # Chạy test login
│       │   │   └── RegressionRunner.java     # Chạy regression suite
│       │   └── stepdefinition/login/
│       │       └── LoginStepDefs.java        # Step definitions cho login
│       └── resources/ui/
│           ├── login/Login.feature           # Kịch bản login (@smoke, @regression)
│           └── homepage/HomePage.feature     # Kịch bản trang chủ
│
├── KarateMavenProject/                   # Karate BDD + JUnit 5 (UI)
│   ├── pom.xml                           # Karate JUnit5 1.5.0
│   ├── mock_server.py                    # Mock server Python hỗ trợ test
│   └── src/test/java/
│       ├── demo_web.feature              # Test login form qua Karate DSL
│       └── UiRunnerTest.java             # JUnit 5 runner cho Karate
│
├── KarateMavenProjectJunit4/             # Karate BDD + JUnit 4 (legacy)
│   ├── pom.xml                           # Karate JUnit4 1.3.1
│   └── src/test/java/
│       ├── demo_web.feature              # Feature file giống bản JUnit5
│       └── UiRunner.java                 # JUnit 4 runner
│
├── DemoKarateAppium/                     # Karate + Appium (Android)
│   ├── pom.xml                           # Karate Core 1.4.1, Maven Surefire
│   ├── README.md
│   └── src/test/java/examples/appium/
│       ├── messages.feature              # Test app Google Messages trên emulator
│       ├── AppiumRunner.java             # JUnit 5 runner cho Appium
│       ├── ScreenshotHook.java           # Chụp screenshot sau mỗi bước test
│       └── karate-config.js             # Cấu hình Appium server & emulator
│
├── DemoKarateFrameworkWithAppiumAndCodexAI/  # Karate + Appium + AI (nâng cao)
│   ├── pom.xml                               # Karate JUnit4 1.3.1, Appium 7.6.0
│   ├── README.md
│   └── src/test/
│       ├── java/
│       │   ├── runners/
│       │   │   └── MessagesRunner.java       # Runner cho test Messages
│       │   └── support/
│       │       ├── MobileDriverFactory.java  # Khởi tạo WebDriver cho mobile
│       │       └── MobileActions.java        # Các hành động mobile dùng lại
│       └── resources/
│           ├── karate-config.js              # Cấu hình global Karate
│           ├── config/
│           │   └── android-emulator.json     # Capabilities cho Android emulator
│           ├── locators/messages/
│           │   ├── home.json                 # Locator màn hình home
│           │   ├── conversation-list.json    # Locator danh sách hội thoại
│           │   └── compose.json              # Locator màn hình soạn tin
│           └── features/mobile/messages/
│               ├── send_hello_world.feature  # Test smoke: gửi "Hello World"
│               └── common/
│                   ├── setup_messages_app.feature    # Bước khởi tạo app
│                   ├── open_start_chat.feature       # Bước mở chat
│                   └── type_and_verify_message.feature # Bước nhập & kiểm tra
│
└── DemoWebDriverIOWithAI/                # WebdriverIO + TypeScript + AI
    ├── package.json                      # WebdriverIO 9.27.0, Appium 3.3.0
    ├── wdio.conf.ts                      # Cấu hình test web
    ├── wdio.android.conf.ts              # Cấu hình Appium Android
    ├── wdio.cross.conf.ts                # Cấu hình cross-platform
    ├── tsconfig.json                     # TypeScript config
    └── test/
        ├── specs/
        │   ├── android/
        │   │   └── messages.spec.ts      # Test Android Messages app
        │   └── cross/
        │       └── webThenMessages.spec.ts  # Test web rồi chuyển sang mobile
        ├── pageobjects/mobile/
        │   └── MessagesPage.ts           # Page Object cho Messages app
        └── helpers/
            ├── actions.ts                # Hành động dùng chung
            ├── mobile-constants.ts       # Hằng số cho mobile
            └── cross-web-session.ts      # Quản lý phiên cross-platform
```

---

## documents/

Tài liệu học tập dạng PowerPoint, bằng tiếng Việt.

```
documents/
└── slides/
    ├── java/                             # Lập trình Java cơ bản (5 bài)
    │   ├── Bai 1- Giới thiệu về Java.pptx
    │   ├── Bai 2- Constructor trong Java va huong dan su dung Maven tool.pptx
    │   ├── Bai 3 -Đoc ghi file.pptx
    │   ├── Bai 4 - Lập trình hướng đối tượng với Java.pptx
    │   └── Bai 5 - Gioi thieu ve TestNG.pptx
    │
    ├── selenium/                         # Selenium WebDriver (5 bài)
    │   ├── Bai 1 - Gioi thieu ve automation test va selenium webdriver.pptx
    │   ├── Bai 2 - Navigation va WebElement commands trong SeleniumWebdriver.pptx
    │   ├── Bai 3 - Tuong tac voi Radio button, Checkbox va kieu Waits trong SeleniumWebdriver.pptx
    │   ├── Bai 4 - Alert và popup window trong SeleniumWebdriver.pptx
    │   └── Bai 5 - Làm việc với chuột và bàn phím trong - gioi thieu POM.pptx
    │
    └── api-webservices/                  # REST API & Web Services (1 bài)
        └── Bai 1- Giới thiệu về Webserivce Restful.pptx
```

---

## web for testing/

Ứng dụng web dùng làm đối tượng kiểm thử (SUT - System Under Test).

```
web for testing/
├── opencart/                             # Ứng dụng OpenCart (thương mại điện tử)
│   ├── administrator/                    # Giao diện quản trị admin
│   │   ├── config.php                    # Cấu hình admin
│   │   └── controller/                  # Controllers: catalog, CMS, sản phẩm...
│   ├── catalog/                          # Giao diện storefront người dùng
│   ├── extension/                        # Các module mở rộng
│   ├── image/                            # Hình ảnh sản phẩm & media
│   ├── db/                               # File database
│   └── system/                           # Thư viện core hệ thống
│
├── storage1/                             # Dữ liệu runtime của OpenCart
│   ├── backup/                           # Backup database
│   ├── cache/                            # Dữ liệu cache
│   ├── download/                         # File tải về
│   ├── logs/                             # Log ứng dụng
│   ├── marketplace/                      # Extension marketplace
│   ├── session/                          # Session người dùng
│   ├── upload/                           # File upload từ người dùng
│   └── vendor/                           # Thư viện bên thứ ba
│
└── opencart_setup.txt                    # Hướng dẫn cài đặt & cấu hình OpenCart
```

---

## Lộ trình học tập

| Bước | Chủ đề | Tài liệu | Dự án mẫu |
|------|--------|----------|-----------|
| 1 | Java cơ bản | `slides/java/Bai 1-4` | `DemoReadFile` |
| 2 | TestNG | `slides/java/Bai 5` | `DemoPOM` |
| 3 | Selenium cơ bản | `slides/selenium/Bai 1-2` | `demos/DemoSelenium` |
| 4 | Selenium nâng cao | `slides/selenium/Bai 3-5` | `DemoSeleniumWithMavenAndJunit5+CheckboxRadio` |
| 5 | Page Object Model | `slides/selenium/Bai 5` | `DemoPOM`, `DemoSeleniumWithMavenAndJunit5POM` |
| 6 | BDD Cucumber | — | `DemoSeleniumWithMavenAndJunit5Cucumber` |
| 7 | REST API | `slides/api-webservices/Bai 1` | `DemoRestfulAPIWebSerivce` |
| 8 | Karate (UI + API) | — | `KarateMavenProject`, `KarateMavenProjectJunit4` |
| 9 | Mobile (Appium) | — | `DemoKarateAppium`, `DemoKarateFrameworkWithAppiumAndCodexAI` |
| 10 | Cross-platform | — | `DemoWebDriverIOWithAI` |
