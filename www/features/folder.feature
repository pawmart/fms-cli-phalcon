Feature: Manage filesystem via CLI
  In order to secure the job at JDI
  As a UNIX user
  I need to be able to perform operations on filesystem

  Background:
    Given I am in root of the project

  Scenario: Create root folder
    When I run "fms folder create test"
    Then I should get:
      """
      Success!
      """
    Then I run "ls"
    Then I should get:
      """
      test
      """

  Scenario: Create a file
    When I run "fms file create test.txt test"
    Then I should get:
      """
      Success!
      """
    Then I run "ls test"
    Then I should get:
      """
      test.txt
      """

  Scenario: Create sub folder first
    When I run "fms folder create test/test2"
    Then I should get:
      """
      Success!
      """
    Then I run "ls test/"
    Then I should get:
      """
      test2
      """

  Scenario: Create sub folder
    When I run "fms folder create test/test2/test3"
    Then I should get:
      """
      Success!
      """
    Then I run "ls test/test2/"
    Then I should get:
      """
      test3
      """

  Scenario: Create file in sub-folder
    When I run "fms file create test2.txt test/test2"
    Then I should get:
      """
      Success!
      """
    Then I run "ls test/test2"
    Then I should get:
      """
      test2.txt
      """

  Scenario: Create sub folder failure
    When I run "fms folder create test/test2/test3/foooo/test"
    Then I should get:
      """
      Failure!
      Folder could not be created. Are you sure base directories are created already?
      """

  Scenario: Create file in sub folder failure
    When I run "fms file create test3.txt test/test2/test3/foooo/test"
    Then I should get:
      """
      Failure!
      File could not be created. Are you sure base directories are created already?
      """

  Scenario: Create folder already exists
    When I run "fms folder create test/test2"
    Then I should get:
      """
      Failure!
      File could not be created. File already exist.
      """

  Scenario: Create file already exists
    When I run "fms file create test2.txt test/test2"
    Then I should get:
      """
      Failure!
      File could not be created. File already exist.
      """

  Scenario: List root folder
    When I run "fms folder list"
    Then I should get:
      """
      test
      """

  Scenario: List folder
    When I run "fms folder list test"
    Then I should get:
      """
      test
      """