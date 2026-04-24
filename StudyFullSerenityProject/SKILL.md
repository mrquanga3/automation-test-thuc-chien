# SKILL.md — Bảng Theo Dõi Kỹ Năng Serenity BDD

> Cập nhật trạng thái học: `[ ]` Chưa học | `[~]` Đang học | `[x]` Đã hoàn thành

---

## Lộ trình học (7 tuần)

| Tuần | Chủ đề | Trạng thái |
|------|--------|-----------|
| 1 | BDD concepts + Setup + Gherkin cơ bản | `[ ]` |
| 2 | Step Definitions + Page Object Pattern | `[ ]` |
| 3 | UI Testing nâng cao | `[ ]` |
| 4 | API Testing với REST Assured | `[ ]` |
| 5 | Screenplay Pattern | `[ ]` |
| 6 | CI/CD + Best Practices | `[ ]` |
| 7+ | Project thực tế | `[ ]` |

---

## Chi tiết kỹ năng theo Module

### Module 1 — BDD & Serenity Fundamentals

- `[ ]` Giải thích được BDD là gì và lợi ích so với manual testing
- `[ ]` Mô tả được vai trò Three Amigos (BA, Dev, Tester)
- `[ ]` Vẽ được kiến trúc tổng thể của Serenity BDD
- `[ ]` So sánh được Serenity BDD với Selenium thuần

---

### Module 2 — Setup & Configuration

- `[ ]` Cài đặt Java 17, Maven, IntelliJ
- `[ ]` Tạo được Maven project mới
- `[ ]` Cấu hình `pom.xml` đầy đủ (dependencies + plugins)
- `[ ]` Tạo và cấu hình `serenity.conf`
- `[ ]` Chạy được lệnh `mvn verify` thành công lần đầu

---

### Module 3 — Gherkin & Feature Files

- `[ ]` Viết được Feature file với cú pháp Gherkin chuẩn
- `[ ]` Sử dụng được: `Given`, `When`, `Then`, `And`, `But`
- `[ ]` Viết được `Background` để tái sử dụng bước chung
- `[ ]` Viết được `Scenario Outline` + `Examples` (data-driven)
- `[ ]` Sử dụng Tags (`@smoke`, `@regression`, `@skip`, v.v.)
- `[ ]` Chạy test lọc theo tag: `mvn verify -Dcucumber.filter.tags`
- `[ ]` Dùng được `DocString` để truyền text nhiều dòng
- `[ ]` Dùng được `DataTable` để truyền dữ liệu dạng bảng

---

### Module 4 — Test Runner

- `[ ]` Tạo được `CucumberTestRunner.java` với JUnit 5
- `[ ]` Hiểu cấu hình `@SelectClasspathResource`, `@ConfigurationParameter`
- `[ ]` Chạy test từ IntelliJ và từ Maven CLI

---

### Module 5 — Step Definitions

- `[ ]` Map Gherkin step với `@Given`, `@When`, `@Then` annotation
- `[ ]` Dùng được Cucumber Expressions: `{string}`, `{int}`, `{double}`, `{word}`
- `[ ]` Dùng được Regex pattern trong step
- `[ ]` Xử lý được `DataTable` trong Step (`asMaps()`, `asLists()`)
- `[ ]` Viết được `Hooks`: `@Before`, `@After`, `@BeforeStep`, `@AfterStep`
- `[ ]` Dùng tag-specific hook: `@Before("@db-cleanup")`

---

### Module 6 — Page Object Pattern

- `[ ]` Tạo Page Object extends `PageObject`
- `[ ]` Dùng `@FindBy` với CSS, ID, XPath, name
- `[ ]` Sử dụng `WebElementFacade` thay vì `WebElement` thuần
- `[ ]` Dùng Serenity shorthand: `$(".css")`, `findAll()`
- `[ ]` Tìm element theo điều kiện với Stream API
- `[ ]` Dùng `@DefaultUrl` để set URL mặc định
- `[ ]` Tạo Page Component (navbar, footer) tái sử dụng
- `[ ]` Dùng assertion: `shouldBeVisible()`, `shouldContainText()`, `shouldHaveValue()`
- `[ ]` Dùng wait: `waitUntilVisible()`, `waitUntilClickable()`, `withTimeoutOf()`

---

### Module 7 — UI Testing nâng cao

- `[ ]` Cấu hình WebDriver (chrome, firefox, headless)
- `[ ]` Xử lý Dropdown/Select
- `[ ]` Upload file
- `[ ]` Scroll đến element bằng JavascriptExecutor
- `[ ]` Switch to iframe và back
- `[ ]` Xử lý Alert/Popup
- `[ ]` Xử lý nhiều tab/window
- `[ ]` Dùng `@Step` annotation để chia nhỏ action
- `[ ]` Inject Step class vào Step Definition bằng `@Steps`

---

### Module 8 — API Testing với REST Assured

- `[ ]` Import `SerenityRest.*` và gọi `given().when().get()`
- `[ ]` Test GET endpoint và verify response
- `[ ]` Test POST endpoint với request body JSON
- `[ ]` Test PUT, DELETE, PATCH
- `[ ]` Dùng Hamcrest matchers: `equalTo`, `containsString`, `notNullValue`, `hasItem`
- `[ ]` Verify mảng trong response (`size()`, `everyItem()`)
- `[ ]` Lấy giá trị từ response với `jsonPath()`
- `[ ]` Verify response time
- `[ ]` Xác thực Basic Auth, Bearer Token, OAuth 2.0, API Key
- `[ ]` Lấy token từ login API và dùng cho request tiếp theo
- `[ ]` Tổ chức `ApiHelper` class tái sử dụng

---

### Module 9 — Screenplay Pattern

- `[ ]` Hiểu các thành phần: Actor, Ability, Task, Interaction, Question
- `[ ]` Tạo Actor với `BrowseTheWeb` ability
- `[ ]` Tạo Task implement `Performable`
- `[ ]` Dùng built-in Interactions: `Click`, `Enter`, `Open`
- `[ ]` Dùng `Target` thay vì `@FindBy` để định nghĩa locator
- `[ ]` Tạo custom `Question` để verify kết quả
- `[ ]` Dùng `actor.should(seeThat(...))` với Hamcrest

---

### Module 10 — Serenity Reports

- `[ ]` Xem và đọc được Serenity HTML report
- `[ ]` Hiểu các section: Test Results, Feature Coverage, Requirements
- `[ ]` Dùng `Serenity.recordReportData()` để thêm thông tin vào report
- `[ ]` Dùng `Serenity.takeScreenshot()` để chụp ảnh thủ công
- `[ ]` Cấu hình screenshot: `FOR_FAILURES`, `AFTER_EACH_STEP`, `DISABLED`
- `[ ]` Thêm narrative và requirement ID vào feature file

---

### Module 11 — Best Practices & CI/CD

- `[ ]` Phân biệt được test tốt và xấu (ngôn ngữ nghiệp vụ vs kỹ thuật)
- `[ ]` Áp dụng Single Responsibility cho Page Object methods
- `[ ]` Tách test data ra file riêng (`testdata/`)
- `[ ]` Cấu hình Parallel Execution trong `serenity.conf`
- `[ ]` Viết được GitHub Actions workflow chạy Serenity test
- `[ ]` Debug test fail: xem report, log, screenshot
- `[ ]` Chạy test trên môi trường cụ thể (`-Denvironment=staging`)

---

## Bài Tập Thực Hành

| Bài | Mô tả | Trạng thái | Ngày hoàn thành |
|-----|-------|-----------|----------------|
| 1 | Google Search (UI cơ bản) | `[ ]` | |
| 2 | JSONPlaceholder API | `[ ]` | |
| 3 | SauceDemo E-commerce (full flow) | `[ ]` | |

---

## Ghi Chú Cá Nhân

> Dùng mục này để ghi lại những điểm khó, lỗi thường gặp, hoặc insights trong quá trình học.

```
[Ngày] — [Ghi chú]
...
```

---

## Checklist "Sẵn sàng đi làm"

- `[ ]` Tự tạo được project Serenity từ đầu (không cần tài liệu)
- `[ ]` Viết feature file theo yêu cầu nghiệp vụ
- `[ ]` Implement Page Object đúng pattern
- `[ ]` Test được API với authentication
- `[ ]` Đọc và giải thích được Serenity report
- `[ ]` Setup được CI/CD pipeline
- `[ ]` Debug được khi test fail
- `[ ]` Hoàn thành cả 3 bài tập thực hành

---

*Cập nhật lần cuối: 2026-04-24*
