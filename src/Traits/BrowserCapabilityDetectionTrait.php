<?php

declare(strict_types = 1);

namespace DrupalTest\BehatTraits\Traits;

use Behat\Mink\Exception\DriverException;
use Behat\Mink\Exception\UnsupportedDriverActionException;
use Behat\MinkExtension\Context\RawMinkContext;

/**
 * Helper methods for detecting browser capabilities.
 *
 * Include this trait in your custom Context class if you want to write step
 * definitions that exhibit different user behaviour in case JavaScript is or
 * isn't available.
 */
trait BrowserCapabilityDetectionTrait {

  /**
   * Checks whether the browser supports JavaScript.
   *
   * @return bool
   *   Returns TRUE when the browser environment supports executing JavaScript
   *   code, for example because the test is running in Selenium or PhantomJS.
   */
  protected function browserSupportsJavaScript(): bool {
    assert($this instanceof RawMinkContext, __METHOD__ . ' should only be included in Context classes that extend RawMinkContext.');

    /** @var \Behat\Mink\Driver\DriverInterface $driver */
    $driver = $this->getSession()->getDriver();
    try {
      if (!$driver->isStarted()) {
        $driver->start();
      }
    }
    catch (DriverException $e) {
      throw new \RuntimeException('Could not start webdriver.', NULL, $e);
    }

    try {
      $driver->executeScript('return;');
      return TRUE;
    }
    catch (UnsupportedDriverActionException $e) {
      return FALSE;
    }
    catch (DriverException $e) {
      throw new \RuntimeException('Could not execute JavaScript.', NULL, $e);
    }
  }

}
