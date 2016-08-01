@mod @mod_php
Feature: A student must be able to add and then edit PHP submission
  In order to edit PHP submission
  As a student
  I need to add PHP submission
  And edit it

  Scenario: Student adding and editing PHP submission
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | student1 | Student   | 1        | student1@example.com |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1 | 0 |
    And the following "course enrolments" exist:
      | user | course | role |
      | student1 | C1 | student |
    And the following "activities" exist:
      | activity | name     | intro    | course | idnumber |
      | php      | Test PHP | Test PHP | C1     | php1     |
    When I log in as "student1"
    And I follow "Course 1"
    And I follow "Test PHP"
    And I set the following fields to these values:
      | id_title | title |
      | id_content_editor | My code |
    And I press "Save changes"
    And I follow "Test PHP"
    And I set the following fields to these values:
      | id_title | title |
      | id_content_editor | My code updated|
    And I press "Save changes"
    And I follow "Test PHP"
    Then I should see "My code updated"
