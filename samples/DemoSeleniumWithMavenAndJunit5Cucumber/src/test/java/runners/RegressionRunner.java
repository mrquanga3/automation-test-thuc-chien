package runners;

import org.junit.platform.suite.api.*;

import static io.cucumber.junit.platform.engine.Constants.GLUE_PROPERTY_NAME;

@Suite
@IncludeEngines("cucumber")
// login feature/steps
@SelectClasspathResource("ui")
//step definition for login
@SelectPackages("stepdefinition")
@ConfigurationParameter(key = GLUE_PROPERTY_NAME, value = "stepdefinition")
@IncludeTags("regression")
public class RegressionRunner {
}
