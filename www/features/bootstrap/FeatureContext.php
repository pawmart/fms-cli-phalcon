<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;

use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use Behat\Behat\Hook\Scope\AfterScenarioScope;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{

    // Load phalcon container, we will need that for DB management.
    use PhalconContainerAware;

    private $output;


    /**
     * @BeforeSuite
     *
     * Initiate db and make sure there is no left over from previous runs.
     */
    public static function prepare(BeforeSuiteScope $scope)
    {
        // reset DB and filesystem
        $db = FeatureContext::getDi()->get('db');

        $db->dropTable('files');
        $db->dropTable('folders');
        $db->dropTable('filesystems');

        // TODO: This should really come as php call, but lets just trigger db cli script for now.
        exec('./run db');
        exec('rm -fr ' . FmsTask::BASEDIR);
    }


    /**
     * @AfterScenario @database
     *
     * Reset db and filesystem.
     */
    public function cleanDB(AfterScenarioScope $scope)
    {
        $db = FeatureContext::getDi()->get('db');

        $db->dropTable('files');
        $db->dropTable('folders');
        $db->dropTable('filesystems');

        exec('rm -fr ' . realpath(FmsTask::BASEDIR));
    }


    /** @Given I am in root of the project */
    public function iAmInRootOfTheProject()
    {
        exec('cd /vagrant/www');
    }


    /** @Given /^I am in a directory "([^"]*)"$/ */
    public function iAmInADirectory($dir)
    {
        if (!file_exists($dir)) {
            mkdir($dir);
        }
        chdir($dir);
    }


    /** @Given /^I have a file named "([^"]*)"$/ */
    public function iHaveAFileNamed($file)
    {
        touch($file);
    }


    /** @When /^I run "([^"]*)"$/ */
    public function iRun($command)
    {
        exec($command, $output);
        $this->output = trim(implode("\n", $output));
    }

    /** @When /^I run task "([^"]*)"$/ */
    public function iRunTask($command)
    {
        exec('./run ' . $command, $output);
        $this->output = trim(implode("\n", $output));
    }


    /** @Then /^I should get:$/ */
    public function iShouldGet(PyStringNode $string)
    {
        if ((string)$string !== $this->output) {
            throw new Exception(
                "Actual output is:\n" . $this->output
            );
        }
    }
}
