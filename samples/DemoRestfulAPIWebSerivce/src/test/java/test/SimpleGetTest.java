package test;

import org.testng.Assert;
import org.testng.annotations.Test;

import io.restassured.RestAssured;
import io.restassured.http.Method;
import io.restassured.response.Response;
import io.restassured.specification.RequestSpecification;

public class SimpleGetTest {
    @Test
    public void testGetUser() {
        // dummy.restapiexample.com is unreliable (HTTP 429 / non-JSON).
        // Use the stable jsonplaceholder API which returns a flat user object.
        RestAssured.baseURI = "https://jsonplaceholder.typicode.com";
        RequestSpecification httpRequest = RestAssured.given();
        Response response = httpRequest.request(Method.GET, "/users/2");

        Assert.assertEquals(response.getStatusCode(), 200);

        int id = response.jsonPath().getInt("id");
        String name = response.jsonPath().getString("name");
        System.out.println("id: " + id);
        System.out.println("name: " + name);

        Assert.assertEquals(id, 2);
        Assert.assertEquals(name, "Ervin Howell");
    }
}
