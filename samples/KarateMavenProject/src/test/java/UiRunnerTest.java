
import com.intuit.karate.junit5.Karate;

public class UiRunnerTest {
    @Karate.Test
    Karate uiRunner() {
        return Karate.run("classpath:demo_web.feature");
    }
}
