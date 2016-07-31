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
     * FeatureContext constructor.
     *
     * @param $output
     */
    public function __construct($output)
    {
        $this->output = $output;
    }

    /**
     * @BeforeSuite
     */
     public static function prepare(BeforeSuiteScope $scope)
     {
         // reset DB and filesystem
         $db = FeatureContext::getDi()->get('db');

         $db->dropTable('files');
         $db->dropTable('folders');
         $db->dropTable('filesystems');

        // TODO: This should really come as php call, but lets just trigger db script for now.
         exec('./run db');
         exec('rm -fr tasks/roottest');
     }

     /**
      * @AfterScenario @database
      */
     public function cleanDB(AfterScenarioScope $scope)
     {
         // clean database after scenarios,
         // tagged with @database

         // reset DB and filesystem
         $db = FeatureContext::getDi()->get('db');

         $db->dropTable('files');
         $db->dropTable('folders');
         $db->dropTable('filesystems');

         exec('rm -fr tasks/roottest');
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
