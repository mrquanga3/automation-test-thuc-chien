
import com.intuit.karate.Results;
import com.intuit.karate.Runner;
import com.intuit.karate.junit4.Karate;
import org.junit.Test;
import org.junit.runner.RunWith;

import static org.junit.Assert.assertEquals;

//@RunWith(Karate.class)
public class UiRunner {
//    @Karate.Test
//    Karate uiRunner(){
//        return Karate.run("classpath:demo_web.feature");
//    }

    @Test
    public void testCustomTags() {
        Results results = Runner
                .path("classpath:demo_web.feature")
                .outputJunitXml(true)
                .parallel(1);
        assertEquals(results.getErrorMessages(), 0, results.getFailCount());
    }
}
