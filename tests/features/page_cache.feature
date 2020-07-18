@api
# Tests for PageCacheTrait.
Feature: Detecting whether pages are cached or cacheable.
  In order to ensure that pages are delivered as quickly as possible
  As a devops performance engineer
  I need to be able to verify that the page cache works as expected

  Scenario: Check that the page cache works properly
    # On a cold cache the pages are not cached, but are cacheable.
    Given the cache has been cleared
    And I am on "/"
    Then the page should not be cached
    But the page should be cacheable

    # Reload the page. Now it should be cached.
    When I reload the page
    Then the page should be cached
    And the page should be cacheable

    # Check the user edit form, it should be uncacheable.
    Given I am logged in as a user with the "administer users" permission
    And I am on "user/1/edit"
    Then the page should not be cached
    And the page should not be cacheable
