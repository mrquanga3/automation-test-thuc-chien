
import com.intuit.karate.Results;
import com.intuit.karate.Runner;
import org.junit.AfterClass;
import org.junit.BeforeClass;
import org.junit.Test;

import static org.junit.Assert.assertEquals;

public class UiRunner {
    static Process mockServer;

    @BeforeClass
    public static void startMockServer() throws Exception {
        String scriptPath = UiRunner.class.getClassLoader()
                .getResource("mock_server.py").getPath();
        mockServer = new ProcessBuilder("python3", scriptPath)
                .redirectErrorStream(true)
                .start();
        Thread.sleep(1500);
    }

    @AfterClass
    public static void stopMockServer() {
        if (mockServer != null) mockServer.destroyForcibly();
    }

    @Test
    public void testCustomTags() {
        Results results = Runner
                .path("classpath:demo_web.feature")
                .outputJunitXml(true)
                .parallel(1);
        assertEquals(results.getErrorMessages(), 0, results.getFailCount());
    }
}
