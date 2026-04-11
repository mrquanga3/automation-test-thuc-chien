# Demo Karate + Appium - Mobile Automation Testing

Project demo sử dụng **Karate framework** kết hợp **Appium** để tự động hoá test ứng dụng Android trên emulator.

## Kiến trúc tổng quan

```
                                          HTTP (WebDriver Protocol)
Feature File (.feature)  -->  Karate Driver  ---------------------->  Appium Server  -->  Android Emulator
     (kịch bản test)         (gửi lệnh)          port 4723            (điều khiển)        (chạy app)
```

### Cấu trúc project

```
src/test/java/
├── karate-config.js                      # Config global: thông tin kết nối Appium + emulator
├── logback-test.xml                      # Config logging
└── examples/appium/
    ├── messages.feature                  # Kịch bản test (mở app Messages, verify UI)
    ├── AppiumRunner.java                 # Entry point - JUnit5 chạy feature file
    └── ScreenshotHook.java              # Hook tự động chụp ảnh sau mỗi step
```

### Giải thích từng file

| File | Vai trò |
|------|---------|
| `karate-config.js` | Khai báo thông tin kết nối: tên emulator, app package, app activity, URL Appium server |
| `messages.feature` | Viết kịch bản test bằng cú pháp Gherkin (Given/When/Then), dễ đọc, dễ hiểu |
| `AppiumRunner.java` | Class Java để Maven/IDE tìm và chạy test, đồng thời gắn ScreenshotHook |
| `ScreenshotHook.java` | Tự động chụp màn hình sau **mỗi step** (kể cả khi test FAIL) và embed vào HTML report |

---

## Yêu cầu cài đặt

### 1. Java JDK 17+

Kiểm tra:
```bash
java -version
```

### 2. Maven

Kiểm tra:
```bash
mvn -version
```

### 3. Android Emulator

- Cài [Android Studio](https://developer.android.com/studio)
- Tạo 1 emulator trong **AVD Manager** (Tools > Device Manager)
- Khởi động emulator

Kiểm tra emulator đang chạy:
```bash
adb devices
```
Kết quả mong đợi:
```
List of devices attached
emulator-5554   device
```

### 4. Appium Server

Cài đặt:
```bash
# Cài Appium
npm install -g appium

# Cài driver cho Android
appium driver install uiautomator2
```

Khởi động:
```bash
appium
```
Kết quả mong đợi: server chạy tại `http://127.0.0.1:4723`

---

## Cách chạy test

### Bước 1: Đảm bảo emulator và Appium đang chạy

```bash
# Terminal 1: Kiểm tra emulator
adb devices

# Terminal 2: Chạy Appium server
appium
```

### Bước 2: Chạy test

```bash
mvn test -Dtest=AppiumRunner
```

### Bước 3: Xem kết quả

- **Console**: hiển thị PASS/FAIL ngay trong terminal
- **HTML Report**: mở file bên dưới trong trình duyệt
  ```
  target/karate-reports/karate-summary.html
  ```
  Report bao gồm: kết quả từng step + ảnh chụp màn hình tự động

---

## Cách lấy thông tin cấu hình cho app khác

Nếu bạn muốn test 1 app khác (không phải Messages), cần lấy 3 thông tin:

### 1. Tên emulator (deviceName)
```bash
adb devices
# Kết quả: emulator-5554
```

### 2. Package name của app (appPackage)
```bash
# Tìm theo từ khoá
adb shell pm list packages | grep <từ-khoá>

# Ví dụ: tìm app Calculator
adb shell pm list packages | grep calc
# Kết quả: package:com.google.android.calculator
```

### 3. Activity chính của app (appActivity)
```bash
adb shell cmd package resolve-activity --brief <package-name>

# Ví dụ:
adb shell cmd package resolve-activity --brief com.google.android.calculator
# Kết quả: com.google.android.calculator/com.android.calculator2.Calculator
# -> appActivity = com.android.calculator2.Calculator
```

Sau đó cập nhật 2 trường `appPackage` và `appActivity` trong file `karate-config.js`.

---

## Cách tìm locator để verify UI

Sau khi mở app, dump UI hierarchy để tìm element:

```bash
adb exec-out uiautomator dump /dev/tty
```

Tìm các thuộc tính hữu ích trong kết quả XML:
- `resource-id` - định danh duy nhất của element (ưu tiên dùng)
- `text` - nội dung hiển thị
- `content-desc` - mô tả (dùng cho accessibility)

Sử dụng trong feature file với XPath:
```gherkin
# Theo resource-id
Then waitFor('//*[@resource-id="com.example.app:id/button_ok"]')

# Theo text
Then waitFor('//*[@text="Submit"]')

# Theo content-desc
Then waitFor('//*[@content-desc="Search"]')
```

---

## Giải thích cách ScreenshotHook hoạt động

```
Karate chạy step 1  -->  afterStep()  -->  có driver?  -->  screenshot()  -->  embed vào report
Karate chạy step 2  -->  afterStep()  -->  có driver?  -->  screenshot()  -->  embed vào report
Karate chạy step 3 (FAIL!)  -->  afterStep()  -->  có driver?  -->  screenshot()  -->  VẪN CHỤP ĐƯỢC
```

Không cần gọi `screenshot()` thủ công trong feature file. Hook xử lý tự động.

---

## Công nghệ sử dụng

| Công nghệ | Phiên bản | Vai trò |
|-----------|-----------|---------|
| Karate | 1.4.1 | Framework BDD, tích hợp WebDriver |
| Appium | 2.x | Automation server cho mobile |
| UiAutomator2 | latest | Driver điều khiển Android |
| JUnit 5 | - | Chạy test từ Maven/IDE |
| Maven | - | Quản lý dependency và build |
