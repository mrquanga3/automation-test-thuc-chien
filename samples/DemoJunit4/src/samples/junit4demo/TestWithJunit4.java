package samples.junit4demo;

import static org.junit.Assert.assertTrue;

import org.junit.Test;

public class TestWithJunit4 {
	public static String encrypt(String username, String password) {
		return username + password;
	}

	@Test
	public void test1() {
		assertTrue("ab".equals(TestWithJunit4.encrypt("a", "b")));
	}

	@Test
	public void test2() {
		assertTrue("ac".equals(TestWithJunit4.encrypt("a", "c")));
	}
}