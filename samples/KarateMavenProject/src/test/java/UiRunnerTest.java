import com.intuit.karate.junit5.Karate;
import org.junit.jupiter.api.AfterAll;
import org.junit.jupiter.api.BeforeAll;

public class UiRunnerTest {

    static Process mockServer;

    @BeforeAll
    static void startMockServer() throws Exception {
        String scriptPath = UiRunnerTest.class.getClassLoader()
                .getResource("mock_server.py").getPath();
        mockServer = new ProcessBuilder("python3", scriptPath)
                .redirectErrorStream(true)
                .start();
        Thread.sleep(1500);
    }

    @AfterAll
    static void stopMockServer() {
        if (mockServer != null) mockServer.destroyForcibly();
    }

    @Karate.Test
    Karate uiRunner() {
        return Karate.run("classpath:demo_web.feature");
    }
}
