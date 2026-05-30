package test;

import java.util.Map;

import org.testng.annotations.Test;

import io.restassured.RestAssured;
import io.restassured.http.Method;
import io.restassured.response.Response;
import io.restassured.specification.RequestSpecification;

public class SimpleGetTest {
    @Test
    public void testWrongUserPassword() {
        RestAssured.baseURI = "http://dummy.restapiexample.com";
        RequestSpecification httpRequest = RestAssured.given();
        Response response = httpRequest.request(Method.GET, "/api/v1/employee/2");
        Map<String, Object> data = response.jsonPath().getMap("data");
        System.out.println("id: " + data.get("id"));
        System.out.println("name: " + data.get("employee_name"));
    }
}
