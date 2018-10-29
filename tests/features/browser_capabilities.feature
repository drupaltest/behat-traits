@api
# Tests for BrowserCapabilityDetectionTrait.
Feature: Browser capability detection
  In order to be able to write user scenarios that work on all possible browser configurations
  As an test engineer
  I need to be able to detect whether certain features are supported by the browser

  @javascript
  Scenario: Detect whether JavaScript is enabled
    Then the browser should support JavaScript

  Scenario: Detect whether JavaScript is disabled
    Then the browser should not support JavaScript
