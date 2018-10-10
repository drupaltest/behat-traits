<?php

declare(strict_types = 1);

namespace DrupalTest\BehatTraits\Context;

use Behat\MinkExtension\Context\RawMinkContext;
use Drupal\Core\Entity\EntityMalformedException;
use Drupal\Core\Entity\Exception\UndefinedLinkTemplateException;
use DrupalTest\BehatTraits\Traits\EntityTrait;

/**
 * Provides example step definitions that interact with entities.
 *
 * These step definitions are mainly intended as an example implementation, and
 * for verifying that the trait is working correctly. They might however also be
 * useful in real life projects. If this is the case, feel free to include this
 * context class in your `behat.yml` file so you can use the provided steps in
 * your user scenarios.
 *
 * @see \DrupalTest\BehatTraits\Traits\EntityTrait
 */
class EntityContext extends RawMinkContext {

  use EntityTrait;

  /**
   * Navigates to the canonical page display of an entity.
   *
   * @param string $entity_type
   *   The human readable entity type.
   * @param string $label
   *   The label for the entity.
   * @param string|null $bundle
   *   Optional human readable entity bundle.
   *
   * @When I go to the :bundle :entity_type titled :label
   * @When I visit the page for the :label :entity_type
   */
  public function visitEntityPage(string $entity_type, string $label, ?string $bundle = NULL) {
    $entity_type_id = self::translateEntityTypeAlias($entity_type);
    $bundle_id = $bundle ? self::translateEntityBundleAlias($entity_type_id, $bundle) : NULL;

    $entity = self::getEntityByLabel($entity_type_id, $label, $bundle_id);
    try {
      $url = $entity->toUrl();
    }
    catch (EntityMalformedException $e) {
      throw new \RuntimeException("Could not generate a URL for the entity of type $entity_type_id and label $label since the entity is malformed.", NULL, $e);
    }
    catch (UndefinedLinkTemplateException $e) {
      throw new \RuntimeException("Could not generate a URL for the entity of type $entity_type_id and label $label since the entity type does not have a link template defined.", NULL, $e);
    }
    $this->visitPath($url->toString());
  }

  /**
   * {@inheritdoc}
   */
  protected static function entityTypeAliases(): array {
    return [
      'article' => 'node',
      'label' => 'taxonomy_term',
      'post' => 'node',
    ];
  }

}
