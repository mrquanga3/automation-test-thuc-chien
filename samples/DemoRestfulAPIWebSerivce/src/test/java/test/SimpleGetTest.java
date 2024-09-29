package test;

import java.util.Map;

import org.testng.Assert;
import org.testng.annotations.Test;

import io.restassured.RestAssured;
import io.restassured.http.Method;
import io.restassured.response.Response;
import io.restassured.specification.RequestSpecification;

public class SimpleGetTest {

	@Test
	public void testWrongUserPassword() {
		// Specify the base URL to the RESTful web service
		RestAssured.baseURI = "http://dummy.restapiexample.com";

		RequestSpecification httpRequest = RestAssured.given();

		Response response = httpRequest.request(Method.GET, "/api/v1/employee/2");

		// System.out.println("Size of list => " + jsonResponse.size());
		Map<String, Object> data = response.jsonPath().getMap("data");
		System.out.print(data.get("id"));
		System.out.print(data.get("name"));
	}

}
