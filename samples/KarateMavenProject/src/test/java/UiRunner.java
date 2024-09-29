import com.intuit.karate.junit5.Karate;

public class UiRunner {
    @Karate.Test
    Karate uiRunner(){
        return Karate.run("classpath:demo_web.feature");
    }
}
