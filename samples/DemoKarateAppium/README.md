# Demo Karate + Appium - Mobile Automation Testing

Project demo su dung **Karate framework** ket hop **Appium** de tu dong hoa test ung dung Android tren emulator.

## Kien truc tong quan

```
                                          HTTP (WebDriver Protocol)
Feature File (.feature)  -->  Karate Driver  ---------------------->  Appium Server  -->  Android Emulator
     (kich ban test)         (gui lenh)          port 4723            (dieu khien)        (chay app)
```

### Cau truc project

```
src/test/java/
├── karate-config.js                      # Config global: thong tin ket noi Appium + emulator
├── logback-test.xml                      # Config logging
└── examples/appium/
    ├── messages.feature                  # Kich ban test (mo app Messages, verify UI)
    ├── AppiumRunner.java                 # Entry point - JUnit5 chay feature file
    └── ScreenshotHook.java              # Hook tu dong chup anh sau moi step
```

### Giai thich tung file

| File | Vai tro |
|------|---------|
| `karate-config.js` | Khai bao thong tin ket noi: ten emulator, app package, app activity, URL Appium server |
| `messages.feature` | Viet kich ban test bang cú phap Gherkin (Given/When/Then), de doc, de hieu |
| `AppiumRunner.java` | Class Java de Maven/IDE tim va chay test, dong thoi gan ScreenshotHook |
| `ScreenshotHook.java` | Tu dong chup man hinh sau **moi step** (ke ca khi test FAIL) va embed vao HTML report |

---

## Yeu cau cai dat

### 1. Java JDK 17+

Kiem tra:
```bash
java -version
```

### 2. Maven

Kiem tra:
```bash
mvn -version
```

### 3. Android Emulator

- Cai [Android Studio](https://developer.android.com/studio)
- Tao 1 emulator trong **AVD Manager** (Tools > Device Manager)
- Khoi dong emulator

Kiem tra emulator dang chay:
```bash
adb devices
```
Ket qua mong doi:
```
List of devices attached
emulator-5554   device
```

### 4. Appium Server

Cai dat:
```bash
# Cai Appium
npm install -g appium

# Cai driver cho Android
appium driver install uiautomator2
```

Khoi dong:
```bash
appium
```
Ket qua mong doi: server chay tai `http://127.0.0.1:4723`

---

## Cach chay test

### Buoc 1: Dam bao emulator va Appium dang chay

```bash
# Terminal 1: Kiem tra emulator
adb devices

# Terminal 2: Chay Appium server
appium
```

### Buoc 2: Chay test

```bash
mvn test -Dtest=AppiumRunner
```

### Buoc 3: Xem ket qua

- **Console**: hien thi PASS/FAIL ngay trong terminal
- **HTML Report**: mo file ben duoi trong trinh duyet
  ```
  target/karate-reports/karate-summary.html
  ```
  Report bao gom: ket qua tung step + anh chup man hinh tu dong

---

## Cach lay thong tin cau hinh cho app khac

Neu ban muon test 1 app khac (khong phai Messages), can lay 3 thong tin:

### 1. Ten emulator (deviceName)
```bash
adb devices
# Ket qua: emulator-5554
```

### 2. Package name cua app (appPackage)
```bash
# Tim theo tu khoa
adb shell pm list packages | grep <tu-khoa>

# Vi du: tim app Calculator
adb shell pm list packages | grep calc
# Ket qua: package:com.google.android.calculator
```

### 3. Activity chinh cua app (appActivity)
```bash
adb shell cmd package resolve-activity --brief <package-name>

# Vi du:
adb shell cmd package resolve-activity --brief com.google.android.calculator
# Ket qua: com.google.android.calculator/com.android.calculator2.Calculator
# -> appActivity = com.android.calculator2.Calculator
```

Sau do cap nhat 2 truong `appPackage` va `appActivity` trong file `karate-config.js`.

---

## Cach tim locator de verify UI

Sau khi mo app, dump UI hierarchy de tim element:

```bash
adb exec-out uiautomator dump /dev/tty
```

Tim cac thuoc tinh huu ich trong ket qua XML:
- `resource-id` - dinh danh duy nhat cua element (uu tien dung)
- `text` - noi dung hien thi
- `content-desc` - mo ta (dung cho accessibility)

Su dung trong feature file voi XPath:
```gherkin
# Theo resource-id
Then waitFor('//*[@resource-id="com.example.app:id/button_ok"]')

# Theo text
Then waitFor('//*[@text="Submit"]')

# Theo content-desc
Then waitFor('//*[@content-desc="Search"]')
```

---

## Giai thich cach ScreenshotHook hoat dong

```
Karate chay step 1  -->  afterStep()  -->  co driver?  -->  screenshot()  -->  embed vao report
Karate chay step 2  -->  afterStep()  -->  co driver?  -->  screenshot()  -->  embed vao report
Karate chay step 3 (FAIL!)  -->  afterStep()  -->  co driver?  -->  screenshot()  -->  VAN CHUP DUOC
```

Khong can goi `screenshot()` thu cong trong feature file. Hook xu ly tu dong.

---

## Cong nghe su dung

| Cong nghe | Phien ban | Vai tro |
|-----------|-----------|---------|
| Karate | 1.4.1 | Framework BDD, tich hop WebDriver |
| Appium | 2.x | Automation server cho mobile |
| UiAutomator2 | latest | Driver dieu khien Android |
| JUnit 5 | - | Chay test tu Maven/IDE |
| Maven | - | Quan ly dependency va build |
