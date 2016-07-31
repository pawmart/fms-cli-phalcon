Feature: Manage filesystem via CLI
  In order to secure the job at JDI
  As a UNIX user
  I need to be able to perform operations on folders

  Scenario: Create root folder
    Given I am in root of the project
    When I run "fms folder create-root test"
    Then I run "ls"
    Then I should get:
    """
    test
    """

  Scenario: Create folder
    Given I am in root of the project
    When I run "fms folder create test/test2"
    Then I run "ls test/"
    Then I should get:
    """
    test2
    """

  Scenario: Create sub folder
    Given I am in root of the project
    When I run "fms folder create test/test2/test3"
    Then I run "ls test/test2/"
    Then I should get:
    """
    test3
    """

  Scenario: Create sub folder failure
    Given I am in root of the project
    When I run "fms folder create test/test2/test3/foooo/test"
    Then I should get:
    """
    Folder could not be created. 'test/test2/test3/foooo/' is not a directory!
    """