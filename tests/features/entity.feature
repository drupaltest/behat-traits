@api
# Tests for EntityTrait.
Feature: Browsing through pages containing different entities
  In order to ensure that all our content is visible to the public
  As a content manager
  I need to be able to see each piece of content on a dedicated page, regardless of the data type

  Scenario: Visit canonical pages of various entity types
    Given tags terms:
      | name      |
      | astronomy |
    And news content:
      | title                                             | field_tags |
      | Black holes ruled out as missing dark matter      | astronomy  |
    And blog_post content:
      | title                                             | field_tags |
      | Astronomers witness matter fall into a black hole | astronomy  |

    When I go to the news article titled "Black holes ruled out as missing dark matter"
    Then I should see the heading "Black holes ruled out as missing dark matter"
    When I go to the blog post titled "Astronomers witness matter fall into a black hole"
    Then I should see the heading "Astronomers witness matter fall into a black hole"
    When I visit the page for the "astronomy" label
    Then I should see the link "Black holes ruled out as missing dark matter"
    And I should see the link "Astronomers witness matter fall into a black hole"

