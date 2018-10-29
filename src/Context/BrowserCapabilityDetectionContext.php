<?php

declare(strict_types = 1);

namespace DrupalTest\BehatTraits\Context;

use Behat\MinkExtension\Context\RawMinkContext;
use DrupalTest\BehatTraits\Traits\BrowserCapabilityDetectionTrait;
use PHPUnit\Framework\Assert;

/**
 * Provides example step definitions that detect browser capabilities.
 *
 * These step definitions are mainly intended for verifying that the trait is
 * working correctly, and might not be terribly useful in real life projects.
 *
 * If this is somehow useful for your project, feel free to include this
 * context class in your `behat.yml` file so you can use the provided steps in
 * your user scenarios.
 *
 * @see \DrupalTest\BehatTraits\Traits\BrowserCapabilityDetectionTrait
 */
class BrowserCapabilityDetectionContext extends RawMinkContext {

  use BrowserCapabilityDetectionTrait;

  /**
   * Verifies that the browser supports JavaScript.
   *
   * @Then the browser should support JavaScript
   */
  public function assertBrowserSupportsJavaScript(): void {
    Assert::assertTrue($this->browserSupportsJavaScript());
  }

  /**
   * Verifies that the browser does not support JavaScript.
   *
   * @Then the browser should not support JavaScript
   */
  public function assertBrowserDoesNotSupportJavaScript(): void {
    Assert::assertFalse($this->browserSupportsJavaScript());
  }

}
