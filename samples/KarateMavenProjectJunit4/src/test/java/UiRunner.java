
import com.intuit.karate.Results;
import com.intuit.karate.Runner;
import org.junit.Test;

import static org.junit.Assert.assertEquals;

public class UiRunner {
    @Test
    public void testCustomTags() {
        Results results = Runner
                .path("classpath:demo_web.feature")
                .outputJunitXml(true)
                .parallel(1);
        assertEquals(results.getErrorMessages(), 0, results.getFailCount());
    }
}
