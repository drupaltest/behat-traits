<?php

declare(strict_types = 1);

namespace DrupalTest\BehatTraits\Traits;

use Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;
use Drupal\Core\Entity\EntityInterface;
use DrupalTest\BehatTraits\Exception\EntityNotFoundException;

/**
 * Helper methods to deal with entities.
 */
trait EntityTrait {

  /**
   * Returns the entity with the given type, bundle and label.
   *
   * If multiple entities have the same label then the first one is returned.
   *
   * @param string $entity_type_id
   *   The entity type to check.
   * @param string $label
   *   The label to check.
   * @param string|null $bundle
   *   Optional bundle to check. If omitted, the entity can be of any bundle.
   *
   * @return \Drupal\Core\Entity\EntityInterface
   *   The requested entity.
   *
   * @throws \DrupalTest\BehatTraits\Exception\EntityNotFoundException
   *   Thrown when an entity with the given type, label and bundle does not
   *   exist.
   */
  protected static function getEntityByLabel(string $entity_type_id, string $label, ?string $bundle = NULL): EntityInterface {
    $entity_manager = \Drupal::entityTypeManager();
    try {
      $storage = $entity_manager->getStorage($entity_type_id);
    }
    catch (InvalidPluginDefinitionException $e) {
      throw new \RuntimeException("The entity storage definition of the $entity_type_id entity type is invalid.", NULL, $e);
    }
    catch (PluginNotFoundException $e) {
      throw new \RuntimeException("The entity storage definition of the $entity_type_id entity type could not be found.", NULL, $e);
    }

    try {
      $entity_definition = $entity_manager->getDefinition($entity_type_id);
    }
    catch (PluginNotFoundException $e) {
      throw new \RuntimeException("The entity storage definition of the $entity_type_id entity type could not be found.", NULL, $e);
    }

    $query = $storage->getQuery()
      ->condition($entity_definition->getKey('label'), $label)
      ->range(0, 1);

    // Optionally filter by bundle.
    if ($bundle) {
      $query->condition($entity_definition->getKey('bundle'), $bundle);
    }

    $result = $query->execute();

    if ($result) {
      $entity_id = reset($result);
      return $storage->load($entity_id);
    }

    throw new EntityNotFoundException("The entity with type '$entity_type_id' and label '$label' was not found.");
  }

  /**
   * Maps human readable entity type names to machine names.
   *
   * One of the main concepts in BDD is the use of a domain specific language
   * to improve the communication between the business and the development
   * team. This means that in our test scenarios we should avoid using
   * technical terms and machine names, and instead we should use a shared
   * terminology that is understood by all.
   *
   * For example using the word "node" to describe content is something that
   * will typically not be understood by business stakeholders. They might
   * prefer "content", "article" or "post". Similarly machine names using
   * underscores should never be used; instead we should use human friendly
   * names. For example a "taxonomy_term" would become a "taxonomy term" (or
   * more likely, a "tag" or "label") in the DSL.
   *
   * Override this method in your custom Context class to provide a mapping
   * between business friendly entity type names that are used in user
   * scenarios to the machine names understood by the Drupal API.
   *
   * Call `::translateEntityTypeAlias()` to perform the actual translation
   * from the human readable name to the entity type ID.
   *
   * @return array
   *   An associative array, with human readable names as keys, and the
   *   corresponding entity type IDs as values.
   */
  protected static function entityTypeAliases(): array {
    return [
      'content' => 'node',
      'label' => 'taxonomy_term',
      'tag' => 'taxonomy_term',
      'taxonomy term' => 'taxonomy_term',
    ];
  }

  /**
   * Translates human readable entity types to machine names.
   *
   * One of the main concepts in BDD is the use of a domain specific language
   * to improve the communication between the business and the development
   * team. This means that in our test scenarios we should avoid using
   * technical terms and machine names, and instead we should use a shared
   * terminology that is understood by all.
   *
   * For example using the word "node" to describe content is something that
   * will typically not be understood by business stakeholders. They might
   * prefer "content", "article" or "post". Similarly machine names using
   * underscores should never be used; instead we should use human friendly
   * names. For example a "taxonomy_term" would become a "taxonomy term" (or
   * more likely, a "tag" or "label") in the DSL.
   *
   * Use this method to translate business friendly entity type names that are
   * used in user scenarios to the machine names understood by the Drupal API.
   *
   * Override `::entityTypeAliases()` in your Context class to provide your
   * own mapping between human friendly names and entity type IDs.
   *
   * @param string $alias
   *   The human readable entity type. Case insensitive.
   *
   * @return string
   *   The machine name of the entity type.
   */
  protected static function translateEntityTypeAlias(string $alias): string {
    $alias = strtolower($alias);
    $aliases = self::entityTypeAliases();
    if (array_key_exists($alias, $aliases)) {
      $alias = $aliases[$alias];
    }
    return $alias;
  }

  /**
   * Maps human readable entity bundle names to machine names.
   *
   * This is the equivalent of ::entityTypeAliases() but for bundles.
   *
   * Override this method in your custom Context class to provide a mapping
   * between business friendly bundle names that are used in user scenarios to
   * the machine names understood by the Drupal API.
   *
   * Call `::translateEntityBundleAlias()` to perform the actual translation
   * from the human readable name to the entity type ID.
   *
   * @return array
   *   An associative array, keyed by entity type. Each value is an associative
   *   array with human readable bundles as keys, and the entity bundle IDs as
   *   values.
   */
  protected static function entityBundleAliases(): array {
    return [
      'node' => [
        'blog post' => 'blog_post',
        'blog' => 'blog_post',
        'news article' => 'news',
      ],
      'taxonomy_term' => [
        'knowledge base topics' => 'kb_topics',
      ],
    ];
  }

  /**
   * Translates human readable entity bundle names to machine names.
   *
   * This is the equivalent of ::entityTypeAliases() but for bundles.
   *
   * Use this method to translate business friendly entity bundle names that are
   * used in user scenarios to the machine names understood by the Drupal API.
   *
   * Override `::entityBundleAliases()` in your Context class to provide your
   * own mapping between human friendly names and entity type IDs.
   *
   * @param string $entity_type_id
   *   The machine name of the entity type for which to retrieve the bundle ID.
   * @param string $alias
   *   The human readable entity bundle name. Case insensitive.
   *
   * @return string
   *   The machine name of the bundle.
   */
  protected static function translateEntityBundleAlias(string $entity_type_id, string $alias): string {
    $alias = strtolower($alias);
    $aliases = self::entityBundleAliases()[$entity_type_id] ?? [];
    if (array_key_exists($alias, $aliases)) {
      $alias = $aliases[$alias];
    }
    return $alias;
  }

}
