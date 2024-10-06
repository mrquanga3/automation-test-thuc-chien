package runners;

import org.junit.platform.suite.api.*;

import static io.cucumber.junit.platform.engine.Constants.GLUE_PROPERTY_NAME;

@Suite
@IncludeEngines("cucumber")
// login feature/steps
@SelectClasspathResource("ui/login")
//step definition for login
@SelectPackages("stepdefinition.login")
@ConfigurationParameter(key = GLUE_PROPERTY_NAME, value = "stepdefinition.login")
@IncludeTags("login_OK")
public class LoginRunner {
}
