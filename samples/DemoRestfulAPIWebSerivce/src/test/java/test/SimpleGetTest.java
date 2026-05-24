package test;

import java.util.Map;

import org.testng.annotations.AfterClass;
import org.testng.annotations.BeforeClass;
import org.testng.annotations.Test;

import io.restassured.RestAssured;
import io.restassured.http.Method;
import io.restassured.response.Response;
import io.restassured.specification.RequestSpecification;

public class SimpleGetTest {
    private static Process mockServer;

    @BeforeClass
    public static void startMockServer() throws Exception {
        String scriptPath = SimpleGetTest.class.getClassLoader()
                .getResource("mock_api_server.py").getPath();
        mockServer = new ProcessBuilder("python3", scriptPath)
                .redirectErrorStream(true)
                .start();
        Thread.sleep(1000);
    }

    @AfterClass
    public static void stopMockServer() {
        if (mockServer != null) mockServer.destroyForcibly();
    }

    @Test
    public void testGetEmployee() {
        RestAssured.baseURI = "http://localhost:29080";
        RequestSpecification httpRequest = RestAssured.given();
        Response response = httpRequest.request(Method.GET, "/api/v1/employee/2");
        Map<String, Object> data = response.jsonPath().getMap("data");
        System.out.println("id: " + data.get("id"));
        System.out.println("name: " + data.get("employee_name"));
    }
}
