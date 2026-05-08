package runners;

import com.intuit.karate.Results;
import com.intuit.karate.Runner;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.junit.Test;

public class MessagesRunner {

    private static final Logger LOGGER = LoggerFactory.getLogger(MessagesRunner.class);

    @Test
    public void testMessagesFlow() {
        LOGGER.info("Starting Karate runner for Android Messages smoke flow");
        Results results = Runner.path("classpath:features/mobile/messages")
                .tags("@android")
                .parallel(1);
        LOGGER.info("Karate run finished. Fail count: {}", results.getFailCount());
        org.junit.Assert.assertEquals(results.getErrorMessages(), 0, results.getFailCount());
    }
}
