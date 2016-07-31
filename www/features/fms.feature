Feature: Manage filesystem via CLI
  In order to secure the job at JDI
  As a UNIX user
  I need to be able to perform operations on filesystem

  Background:
    Given I am in root of the project

  Scenario: Create filesystem
    When I run task "fms filesystem"
    Then I should get:
      """
      Success!
      """

  Scenario: Create root folder
    When I run task "fms folder create test"
    Then I should get:
      """
      Success!
      """
    Then I run "ls filesystem"
    Then I should get:
      """
      test
      """

  Scenario: Create folder
    When I run task "fms folder create test/test2"
    Then I should get:
      """
      Success!
      """
    Then I run "ls filesystem/test"
    Then I should get:
      """
      test2
      """

  Scenario: Create a file
    When I run task "fms file create test.txt test"
    Then I should get:
      """
      Success!
      """
    Then I run "ls filesystem/test"
    Then I should get:
      """
      test2
      test.txt
      """
