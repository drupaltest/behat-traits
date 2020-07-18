<?php

declare(strict_types = 1);

namespace DrupalTest\BehatTraits\Context;

use Behat\MinkExtension\Context\RawMinkContext;
use DrupalTest\BehatTraits\Traits\PageCacheTrait;
use PHPUnit\Framework\Assert;

/**
 * Provides example step definitions that interact with the page cache.
 *
 * These step definitions are mainly intended as an example implementation, and
 * for verifying that the trait is working correctly. They might however also be
 * useful in real life projects. If this is the case, feel free to include this
 * context class in your `behat.yml` file so you can use the provided steps in
 * your user scenarios.
 *
 * @see \DrupalTest\BehatTraits\Traits\PageCacheTrait
 */
class PageCacheContext extends RawMinkContext {

  use PageCacheTrait;

  /**
   * Checks that the page is cacheable.
   *
   * @Then the page should be cacheable
   */
  public function assertPageCacheable(): void {
    Assert::assertTrue($this->isPageCacheable());
  }

  /**
   * Checks that the page is not cacheable.
   *
   * @Then the page should not be cacheable
   */
  public function assertPageNotCacheable(): void {
    Assert::assertFalse($this->isPageCacheable());
  }

  /**
   * Checks that the page is cached.
   *
   * @Then the page should be cached
   */
  public function assertPageCached(): void {
    Assert::assertTrue($this->isPageCached());
  }

  /**
   * Checks that the page is not cached.
   *
   * @Then the page should not be cached
   */
  public function assertPageNotCached(): void {
    Assert::assertFalse($this->isPageCached());
  }

}
