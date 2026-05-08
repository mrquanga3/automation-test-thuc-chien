# CLAUDE.md — Hướng dẫn cho Claude Code

## Tổng quan Project

**SerenityProject** là project giáo trình/demo học Serenity BDD dành cho người mới bắt đầu.  
Ngôn ngữ: Java 17 | Build tool: Maven | Framework: Serenity BDD + Cucumber + JUnit 5.

## Mục đích

Project này được dùng để:
1. Học và thực hành Serenity BDD từ cơ bản đến nâng cao
2. Làm demo/ví dụ minh họa cho giáo trình trong `README.md`
3. Thực hành bài tập ở Module 12 của giáo trình

## Cấu trúc Project (khi đầy đủ)

```
SerenityPrject/
├── pom.xml                              ← Maven config + dependencies
├── README.md                            ← Giáo trình dạng slide
├── CLAUDE.md                            ← File này
├── SKILL.md                             ← Bảng theo dõi kỹ năng
└── src/
    ├── main/java/                        ← (trống, project test only)
    └── test/
        ├── java/com/example/
        │   ├── runners/                  ← CucumberTestRunner
        │   ├── stepdefinitions/          ← Step Definitions (Cucumber)
        │   ├── pages/                    ← Page Objects (Serenity)
        │   └── actions/                  ← Screenplay Tasks/Actions
        └── resources/
            ├── serenity.conf             ← Serenity configuration
            ├── features/                 ← Gherkin feature files
            └── testdata/                 ← CSV, JSON test data files
```

## Các lệnh thường dùng

```bash
# Chạy tất cả test
mvn verify

# Chạy theo tag
mvn verify -Dcucumber.filter.tags="@smoke"

# Chạy trên môi trường staging
mvn verify -Denvironment=staging

# Chạy headless (không mở browser)
mvn verify -Dwebdriver.chrome.switches="--headless=new"

# Xem report (sau khi chạy)
# Windows: start target/site/serenity/index.html
# Mac/Linux: open target/site/serenity/index.html

# Clean build
mvn clean verify
```

## Stack kỹ thuật

| Thành phần | Version | Mục đích |
|-----------|---------|---------|
| Java | 17 | Ngôn ngữ lập trình |
| Maven | 3.8+ | Build tool |
| Serenity BDD | 4.1.20 | Test framework chính |
| Cucumber | 7.15.0 | BDD / Feature files |
| JUnit | 5.10.1 | Test runner |
| Selenium | (bundled) | UI automation |
| REST Assured | (bundled) | API testing |

## Conventions

### Đặt tên file
- Feature files: `src/test/resources/features/<domain>/<feature_name>.feature`
- Page Objects: `src/test/java/com/example/pages/<PageName>Page.java`
- Step Definitions: `src/test/java/com/example/stepdefinitions/<Domain>Steps.java`
- Actions (Screenplay): `src/test/java/com/example/actions/<ActionName>.java`

### Tags chuẩn
| Tag | Ý nghĩa |
|-----|---------|
| `@smoke` | Test smoke (chạy nhanh, test cơ bản) |
| `@regression` | Test hồi quy đầy đủ |
| `@ui` | Test giao diện web |
| `@api` | Test API |
| `@wip` | Work in progress — chưa hoàn thiện |
| `@skip` | Bỏ qua — không chạy |
| `@debug` | Dùng khi debug thủ công |

### Nguyên tắc code
- Step Definition chỉ được gọi Page Object/Action — không chứa logic Selenium trực tiếp
- Page Object extend `PageObject`, dùng `@FindBy` + `WebElementFacade`
- Không dùng `Thread.sleep()` — dùng `waitUntilVisible()` hoặc `withTimeoutOf()`
- Test data không hardcode trong step — đọc từ `testdata/` hoặc `Examples:`

## Môi trường

Cấu hình trong `src/test/resources/serenity.conf`:
- `default`: môi trường local / dev
- `staging`: môi trường staging
- `production`: môi trường production

Chọn môi trường khi chạy: `mvn verify -Denvironment=staging`

## Báo cáo test

Sau khi chạy `mvn verify`, report được generate tại:
```
target/site/serenity/index.html
```

## Lưu ý khi làm việc với project này

- Project đang ở giai đoạn học tập — code ví dụ trong README.md là tham khảo
- Khi tạo code mới, đặt đúng package `com.example.*`
- Luôn cập nhật `SKILL.md` khi thêm module/bài học mới
- Khi thêm dependency mới vào `pom.xml`, ghi rõ version cụ thể
